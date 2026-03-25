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
        $sppgId = session()->get('sppg_id');
        $builder = $this->bukuKasModel->orderBy('tanggal', 'DESC');
        
        if ($sppgId) {
            $builder->where('sppg_id', $sppgId);
        }

        $data = [
            'title'   => 'Buku Kas Operasional',
            'entries' => $builder->findAll(100),
            'summary' => $this->bukuKasModel->getSummary($sppgId, date('Y-m-01'), date('Y-m-t'))
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
        $sppgId    = session()->get('sppg_id') ?: 1;
        $createdBy = session()->get('user_id');
        
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

    public function report()
    {
        $sppgId = session()->get('sppg_id') ?: 1;
        $start  = $this->request->getGet('start') ?: date('Y-m-d');
        $end    = $this->request->getGet('end') ?: $start;

        $entries = $this->bukuKasModel->where('sppg_id', $sppgId)
                                     ->where('tanggal >=', $start)
                                     ->where('tanggal <=', $end)
                                     ->orderBy('tanggal', 'ASC')
                                     ->findAll();

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
        $sppgId = session()->get('sppg_id') ?: 1;
        $start  = $this->request->getGet('start');
        $end    = $this->request->getGet('end');

        $entries = $this->bukuKasModel->where('sppg_id', $sppgId)
                                     ->where('tanggal >=', $start)
                                     ->where('tanggal <=', $end)
                                     ->orderBy('tanggal', 'ASC')
                                     ->findAll();

        $data = [
            'title'   => 'Laporan Buku Kas Operasional',
            'entries' => $entries,
            'start'   => $start,
            'end'     => $end,
            'summary' => $this->bukuKasModel->getSummary($sppgId, $start, $end),
            'header'  => [
                'nama_sppg' => session()->get('sppg_nama') ?? 'Dapur SPPG Bunar',
                'alamat_sppg' => 'KP. BEJI No.001, RT.004, Bunar, Kec. Sukamulya, Kabupaten Tangerang, Banten',
                'kepala_sppg' => 'M. Rizki Waluya, S.P.W.K'
            ]
        ];

        return view('buku_kas/print', $data);
    }

    public function exportExcel()
    {
        $sppgId = session()->get('sppg_id') ?: 1;
        $start  = $this->request->getGet('start');
        $end    = $this->request->getGet('end');

        $entries = $this->bukuKasModel->where('sppg_id', $sppgId)
                                     ->where('tanggal >=', $start)
                                     ->where('tanggal <=', $end)
                                     ->orderBy('tanggal', 'ASC')
                                     ->findAll();

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
        $sppgId = session()->get('sppg_id');
        $this->bukuKasModel->where(['id' => $id, 'sppg_id' => $sppgId])->delete();
        return redirect()->back()->with('success', 'Data dihapus');
    }
}
