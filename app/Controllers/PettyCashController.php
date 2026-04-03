<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PettyCashController extends BaseController
{
    protected $pettyCashModel;

    public function __construct()
    {
        $this->pettyCashModel = new \App\Models\PettyCashModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $sppgId = session()->get('sppg_id');
        
        $totalBuilder = $this->pettyCashModel->selectSum('pemasukkan', 'in')
                                            ->selectSum('pengeluaran', 'out');
        
        $entryBuilder = $this->pettyCashModel->orderBy('tanggal', 'DESC');
        
        if ($role == 'admin' || $role == 'pic') {
            if ($sppgId) {
                $totalBuilder->where('sppg_id', $sppgId);
                $entryBuilder->where('sppg_id', $sppgId);
            }
        }
        
        $totalAll = $totalBuilder->first();

        $data = [
            'title'        => 'Laporan Petty Cash',
            'entries'      => $entryBuilder->findAll(100),
            'summary'      => $this->pettyCashModel->getSummary($sppgId, date('Y-m-01'), date('Y-m-t')),
            'currentSaldo' => ($totalAll['in'] ?? 0) - ($totalAll['out'] ?? 0),
            'user_sppg_id' => $this->resolveUserSppgId(),
        ];

        return view('petty_cash/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Input Petty Cash',
            'today' => date('Y-m-d')
        ];
        return view('petty_cash/create', $data);
    }

    public function store()
    {
        $sppgId    = session()->get('sppg_id');
        $createdBy = session()->get('user_id');
        
        // Fallback: get sppg_id from user record if session is stale
        if (!$sppgId && $createdBy) {
            $user = (new \App\Models\UserModel())->find($createdBy);
            $sppgId = $user['sppg_id'] ?? null;
            if ($sppgId) session()->set('sppg_id', $sppgId);
        }
        
        $tanggal    = $this->request->getPost('tanggal');
        $keterangan = $this->request->getPost('keterangan');
        $pemasukkan = $this->request->getPost('pemasukkan');
        $pengeluaran = $this->request->getPost('pengeluaran');

        if ($keterangan) {
            foreach ($keterangan as $i => $ket) {
                if (empty($ket)) continue;
                
                $this->pettyCashModel->insert([
                    'sppg_id'    => $sppgId,
                    'created_by' => $createdBy,
                    'tanggal'    => $tanggal,
                    'keterangan' => $ket,
                    'pemasukkan' => $pemasukkan[$i] ?? 0,
                    'pengeluaran' => $pengeluaran[$i] ?? 0,
                ]);
            }
        }

        return redirect()->to('/petty-cash')->with('success', 'Catatan petty cash berhasil disimpan');
    }

    public function edit($id)
    {
        $row = $this->pettyCashModel->find($id);
        if (!$row) {
            return redirect()->to('/petty-cash')->with('error', 'Data tidak ditemukan.');
        }
        if (!$this->userCanEditPettyCash($row)) {
            return redirect()->to('/petty-cash')->with('error', 'Anda tidak memiliki akses mengubah entri ini.');
        }

        $data = [
            'title' => 'Ubah Entri Petty Cash',
            'entry' => $row,
        ];

        return view('petty_cash/edit', $data);
    }

    public function update($id)
    {
        $row = $this->pettyCashModel->find($id);
        if (!$row) {
            return redirect()->to('/petty-cash')->with('error', 'Data tidak ditemukan.');
        }
        if (!$this->userCanEditPettyCash($row)) {
            return redirect()->to('/petty-cash')->with('error', 'Anda tidak memiliki akses mengubah entri ini.');
        }

        $tanggal     = $this->request->getPost('tanggal');
        $keterangan  = $this->request->getPost('keterangan');
        $pemasukkan  = (float) $this->request->getPost('pemasukkan');
        $pengeluaran = (float) $this->request->getPost('pengeluaran');

        if (empty($keterangan)) {
            return redirect()->back()->withInput()->with('error', 'Keterangan wajib diisi.');
        }

        $this->pettyCashModel->update($id, [
            'tanggal'     => $tanggal,
            'keterangan'  => $keterangan,
            'pemasukkan'  => $pemasukkan,
            'pengeluaran' => $pengeluaran,
        ]);

        return redirect()->to('/petty-cash')->with('success', 'Entri berhasil diperbarui.');
    }

    public function report()
    {
        $sppgId = session()->get('sppg_id');
        $start  = $this->request->getGet('start') ?: date('Y-m-d');
        $end    = $this->request->getGet('end') ?: $start;

        // Calculate Saldo Awal (before start date)
        $prevBuilder = $this->pettyCashModel->selectSum('pemasukkan', 'in')
                                          ->selectSum('pengeluaran', 'out')
                                          ->where('tanggal <', $start);
        if ($sppgId) {
            $prevBuilder->where('sppg_id', $sppgId);
        }
        $prevBalance = $prevBuilder->first();
        
        $saldoAwal = ($prevBalance['in'] ?? 0) - ($prevBalance['out'] ?? 0);

        $entryBuilder = $this->pettyCashModel->where('tanggal >=', $start)
                                       ->where('tanggal <=', $end)
                                       ->orderBy('tanggal', 'ASC');
        if ($sppgId) {
            $entryBuilder->where('sppg_id', $sppgId);
        }
        $entries = $entryBuilder->findAll();

        $data = [
            'title'     => 'Laporan Petty Cash',
            'entries'   => $entries,
            'start'     => $start,
            'end'       => $end,
            'saldoAwal' => $saldoAwal,
            'summary'   => $this->pettyCashModel->getSummary($sppgId, $start, $end)
        ];

        return view('petty_cash/report', $data);
    }

    public function exportPdf()
    {
        $sppgId = session()->get('sppg_id');
        $start  = $this->request->getGet('start');
        $end    = $this->request->getGet('end');

        $prevBuilder = $this->pettyCashModel->selectSum('pemasukkan', 'in')
                                          ->selectSum('pengeluaran', 'out')
                                          ->where('tanggal <', $start);
        if ($sppgId) {
            $prevBuilder->where('sppg_id', $sppgId);
        }
        $prevBalance = $prevBuilder->first();
        
        $saldoAwal = ($prevBalance['in'] ?? 0) - ($prevBalance['out'] ?? 0);

        $entryBuilder = $this->pettyCashModel->where('tanggal >=', $start)
                                       ->where('tanggal <=', $end)
                                       ->orderBy('tanggal', 'ASC');
        if ($sppgId) {
            $entryBuilder->where('sppg_id', $sppgId);
        }
        $entries = $entryBuilder->findAll();

        $data = [
            'title'     => 'LAPORAN PEMASUKKAN & PENGELUARAN PETTY CASH',
            'entries'   => $entries,
            'start'     => $start,
            'end'       => $end,
            'saldoAwal' => $saldoAwal,
            'summary'   => $this->pettyCashModel->getSummary($sppgId, $start, $end)
        ];

        return view('petty_cash/print', $data);
    }

    public function exportPdfBlank()
    {
        helper('print');
        $entries = [];
        for ($i = 0; $i < 14; $i++) {
            $entries[] = ['tanggal' => '', 'keterangan' => '', 'pemasukkan' => 0, 'pengeluaran' => 0];
        }

        return view('petty_cash/print', [
            'blank'     => true,
            'title'     => 'Laporan Petty Cash (form kosong)',
            'entries'   => $entries,
            'start'     => '',
            'end'       => '',
            'saldoAwal' => 0,
            'summary'   => ['pemasukkan' => 0, 'pengeluaran' => 0],
        ]);
    }

    public function exportExcel()
    {
        $sppgId = session()->get('sppg_id');
        $start  = $this->request->getGet('start');
        $end    = $this->request->getGet('end');

        $prevBuilder = $this->pettyCashModel->selectSum('pemasukkan', 'in')
                                          ->selectSum('pengeluaran', 'out')
                                          ->where('tanggal <', $start);
        if ($sppgId) {
            $prevBuilder->where('sppg_id', $sppgId);
        }
        $prevBalance = $prevBuilder->first();
        
        $saldoAwal = ($prevBalance['in'] ?? 0) - ($prevBalance['out'] ?? 0);

        $entryBuilder = $this->pettyCashModel->where('tanggal >=', $start)
                                       ->where('tanggal <=', $end)
                                       ->orderBy('tanggal', 'ASC');
        if ($sppgId) {
            $entryBuilder->where('sppg_id', $sppgId);
        }
        $entries = $entryBuilder->findAll();

        $filename = "Petty_Cash_".date('Ymd', strtotime($start))."_".date('Ymd', strtotime($end)).".csv";
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        
        $output = fopen('php://output', 'w');
        fputs($output, "\xEF\xBB\xBF");
        
        fputcsv($output, ['LAPORAN PEMASUKKAN & PENGELUARAN PETTY CASH']);
        fputcsv($output, ['Periode:', $start, 's/d', $end]);
        fputcsv($output, []);
        fputcsv($output, ['TANGGAL', 'KETERANGAN', 'PEMASUKKAN', 'PENGELUARAN', 'SALDO']);

        $runningSaldo = $saldoAwal;
        fputcsv($output, ['', 'Saldo Awal', '', '', $runningSaldo]);

        foreach ($entries as $row) {
            $runningSaldo += $row['pemasukkan'] - $row['pengeluaran'];
            fputcsv($output, [
                $row['tanggal'],
                $row['keterangan'],
                (float)$row['pemasukkan'],
                (float)$row['pengeluaran'],
                (float)$runningSaldo
            ]);
        }
        
        fclose($output);
        exit;
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }
        
        $this->pettyCashModel->delete($id);
        return redirect()->back()->with('success', 'Catatan berhasil dihapus.');
    }

    private function resolveUserSppgId(): ?int
    {
        $sppgId = session()->get('sppg_id');
        $userId = session()->get('user_id');
        if (!$sppgId && $userId) {
            $user = (new \App\Models\UserModel())->find($userId);
            $sppgId = $user['sppg_id'] ?? null;
            if ($sppgId) {
                session()->set('sppg_id', $sppgId);
            }
        }

        return $sppgId !== null && $sppgId !== '' ? (int) $sppgId : null;
    }

    private function userCanEditPettyCash(array $row): bool
    {
        $role = session()->get('role');
        if ($role === 'admin') {
            return true;
        }
        if ($role !== 'akuntan') {
            return false;
        }
        $userSppg = $this->resolveUserSppgId();
        if ($userSppg === null) {
            return false;
        }

        return (int) ($row['sppg_id'] ?? 0) === $userSppg;
    }
}
