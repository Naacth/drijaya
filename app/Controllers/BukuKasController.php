<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BukuKasController extends BaseController
{
    protected $bukuKasModel;

    public function __construct()
    {
        $this->bukuKasModel = new \App\Models\BukuKasModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $sppgId = $this->resolveUserSppgId();
        
        $builder = $this->bukuKasModel->orderBy('tanggal', 'DESC');
        if (in_array($role, ['admin', 'pic', 'akuntan']) && $sppgId) {
            $builder->where('sppg_id', $sppgId);
        }

        $data = [
            'title'         => 'Buku Kas Operasional',
            'entries'       => $builder->findAll(100),
            'summary'       => $this->bukuKasModel->getSummary($sppgId, date('Y-m-01'), date('Y-m-t')),
            'user_sppg_id'  => $sppgId,
        ];

        return view('buku_kas/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Input Operasional Harian',
            'today' => date('Y-m-d')
        ];
        return view('buku_kas/create', $data);
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
        $debet      = $this->request->getPost('debet');
        $kredit     = $this->request->getPost('kredit');

        if ($keterangan) {
            foreach ($keterangan as $i => $ket) {
                if (empty($ket)) continue;
                
                $this->bukuKasModel->insert([
                    'sppg_id'    => $sppgId,
                    'created_by' => $createdBy,
                    'tanggal'    => $tanggal,
                    'keterangan' => $ket,
                    'debet'      => $debet[$i] ?? 0,
                    'kredit'     => $kredit[$i] ?? 0,
                ]);
            }
        }

        return redirect()->to('/buku-kas')->with('success', 'Entri operasional berhasil disimpan');
    }

    public function edit($id)
    {
        $row = $this->bukuKasModel->find($id);
        if (!$row) {
            return redirect()->to('/buku-kas')->with('error', 'Data tidak ditemukan.');
        }
        if (!$this->userCanEditBukuKas($row)) {
            return redirect()->to('/buku-kas')->with('error', 'Anda tidak memiliki akses mengubah entri ini.');
        }

        $data = [
            'title' => 'Ubah Entri Buku Kas',
            'entry' => $row,
        ];

        return view('buku_kas/edit', $data);
    }

    public function update($id)
    {
        $row = $this->bukuKasModel->find($id);
        if (!$row) {
            return redirect()->to('/buku-kas')->with('error', 'Data tidak ditemukan.');
        }
        if (!$this->userCanEditBukuKas($row)) {
            return redirect()->to('/buku-kas')->with('error', 'Anda tidak memiliki akses mengubah entri ini.');
        }

        $tanggal    = $this->request->getPost('tanggal');
        $keterangan = $this->request->getPost('keterangan');
        $debet      = (float) $this->request->getPost('debet');
        $kredit     = (float) $this->request->getPost('kredit');

        if (empty($keterangan)) {
            return redirect()->back()->withInput()->with('error', 'Keterangan wajib diisi.');
        }

        $this->bukuKasModel->update($id, [
            'tanggal'    => $tanggal,
            'keterangan' => $keterangan,
            'debet'      => $debet,
            'kredit'     => $kredit,
        ]);

        return redirect()->to('/buku-kas')->with('success', 'Entri berhasil diperbarui.');
    }

    public function report()
    {
        $sppgId = session()->get('sppg_id');
        $start  = $this->request->getGet('start') ?: date('Y-m-d');
        $end    = $this->request->getGet('end') ?: $start;

        $builder = $this->bukuKasModel->where('tanggal >=', $start)
                                     ->where('tanggal <=', $end)
                                     ->orderBy('tanggal', 'ASC');
        if ($sppgId) {
            $builder->where('sppg_id', $sppgId);
        }
        $entries = $builder->findAll();

        $data = [
            'title'   => 'Laporan Operasional',
            'entries' => $entries,
            'start'   => $start,
            'end'     => $end,
            'summary' => $this->bukuKasModel->getSummary($sppgId, $start, $end)
        ];

        return view('buku_kas/report', $data);
    }

    public function exportPdf()
    {
        $sppgId = session()->get('sppg_id');
        $start  = $this->request->getGet('start');
        $end    = $this->request->getGet('end');

        $builder = $this->bukuKasModel->where('tanggal >=', $start)
                                     ->where('tanggal <=', $end)
                                     ->orderBy('tanggal', 'ASC');
        if ($sppgId) {
            $builder->where('sppg_id', $sppgId);
        }
        $entries = $builder->findAll();

        $data = [
            'title'   => 'Laporan Buku Kas Operasional',
            'entries' => $entries,
            'start'   => $start,
            'end'     => $end,
            'summary' => $this->bukuKasModel->getSummary($sppgId, $start, $end),
            'header'  => [
                'nama_sppg' => session()->get('sppg_nama') ?? 'Dapur SPPG',
                'alamat_sppg' => session()->get('sppg_alamat') ?? 'Alamat belum diatur',
                'kepala_sppg' => 'PIC SPPG'
            ]
        ];

        return view('buku_kas/print', $data);
    }

    public function exportPdfBlank()
    {
        helper('print');
        $entries = [];
        for ($i = 0; $i < 16; $i++) {
            $entries[] = ['tanggal' => '', 'keterangan' => '', 'debet' => 0, 'kredit' => 0];
        }

        return view('buku_kas/print', [
            'blank'   => true,
            'title'   => 'Buku Kas Operasional (form kosong)',
            'entries' => $entries,
            'start'   => '',
            'end'     => '',
            'summary' => ['debet' => 0, 'kredit' => 0],
            'header'  => [
                'nama_sppg'   => session()->get('sppg_nama') ?? '',
                'alamat_sppg' => session()->get('sppg_alamat') ?? '',
                'kepala_sppg' => '',
            ],
        ]);
    }

    public function exportExcel()
    {
        $sppgId = session()->get('sppg_id');
        $start  = $this->request->getGet('start');
        $end    = $this->request->getGet('end');

        $builder = $this->bukuKasModel->where('tanggal >=', $start)
                                     ->where('tanggal <=', $end)
                                     ->orderBy('tanggal', 'ASC');
        if ($sppgId) {
            $builder->where('sppg_id', $sppgId);
        }
        $entries = $builder->findAll();

        $filename = "Laporan_Operasional_".date('Ymd', strtotime($start))."_".date('Ymd', strtotime($end)).".csv";
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        
        $output = fopen('php://output', 'w');
        fputs($output, "\xEF\xBB\xBF"); // UTF-8 BOM
        
        fputcsv($output, ['LAPORAN BUKU KAS OPERASIONAL']);
        fputcsv($output, ['Periode:', $start, 's/d', $end]);
        fputcsv($output, []);
        fputcsv($output, ['TANGGAL', 'OPERASIONAL', 'DEBET', 'KREDIT']);

        $totalDebet = 0;
        $totalKredit = 0;

        foreach ($entries as $row) {
            fputcsv($output, [
                $row['tanggal'],
                $row['keterangan'],
                (float)$row['debet'],
                (float)$row['kredit']
            ]);
            $totalDebet += $row['debet'];
            $totalKredit += $row['kredit'];
        }

        fputcsv($output, []);
        fputcsv($output, ['', 'TOTAL', $totalDebet, $totalKredit]);
        
        fclose($output);
        exit;
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }
        
        $this->bukuKasModel->delete($id);
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    private function userCanEditBukuKas(array $row): bool
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
