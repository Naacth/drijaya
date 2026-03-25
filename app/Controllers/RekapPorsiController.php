<?php

namespace App\Controllers;

use App\Models\RekapPorsiModel;
use App\Models\RekapPorsiItemModel;

class RekapPorsiController extends BaseController
{
    protected $headerModel;
    protected $itemModel;

    public function __construct()
    {
        $this->headerModel = new RekapPorsiModel();
        $this->itemModel   = new RekapPorsiItemModel();
    }

    public function index()
    {
        $role   = session()->get('role');
        $userId = session()->get('user_id');

        $db = \Config\Database::connect();
        $builder = $db->table('rekap_porsi');
        $builder->select('rekap_porsi.*, users.nama as user_nama');
        $builder->join('users', 'users.id = rekap_porsi.created_by');

        if ($role == 'aslap') {
            $builder->where('rekap_porsi.created_by', $userId);
        } elseif ($role == 'admin') {
            $currentSppgId = session()->get('sppg_id');
            if ($currentSppgId) {
                $builder->where('users.sppg_id', $currentSppgId);
            }
        }
        $builder->orderBy('rekap_porsi.created_at', 'DESC');

        $data['title'] = 'Rekap Jumlah Porsi';
        $data['forms'] = $builder->get()->getResultArray();

        return view('rekap_porsi/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Input Rekap Porsi';
        return view('rekap_porsi/create', $data);
    }

    public function store()
    {
        $items = $this->request->getPost('items');
        if (empty($items)) {
            return redirect()->back()->with('error', 'Minimal harus mengisi 1 baris.')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $headerId = $this->headerModel->insert([
            'tanggal'    => $this->request->getPost('tanggal'),
            'created_by' => session()->get('user_id'),
        ]);

        foreach ($items as $item) {
            // Optional basic filtering
            if (empty($item['sekolah'])) continue;

            $this->itemModel->insert([
                'rekap_porsi_id'             => $headerId,
                'tingkatan'                  => $item['tingkatan'] ?? '',
                'sekolah'                    => $item['sekolah'],
                'jumlah_pm'                  => (int)($item['jumlah_pm'] ?? 0),
                'jumlah_terdistribusi'       => (int)($item['jumlah_terdistribusi'] ?? 0),
                'jumlah_tidak_terdistribusi' => (int)($item['jumlah_tidak_terdistribusi'] ?? 0),
                'keterangan'                 => $item['keterangan'] ?? '',
                'pengalihan'                 => $item['pengalihan'] ?? '',
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan.')->withInput();
        }

        return redirect()->to('/rekap-porsi')->with('success', 'Rekap Porsi berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('rekap_porsi');
        $builder->select('rekap_porsi.*, users.nama as user_nama');
        $builder->join('users', 'users.id = rekap_porsi.created_by');
        $builder->where('rekap_porsi.id', $id);
        $header = $builder->get()->getRowArray();

        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data['header'] = $header;
        $data['items']  = $this->itemModel->where('rekap_porsi_id', $id)->findAll();
        $data['title']  = 'Detail Rekap Porsi';

        return view('rekap_porsi/show', $data);
    }

    public function exportPdf($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data['header'] = $header;
        $data['items']  = $this->itemModel->where('rekap_porsi_id', $id)->findAll();
        $data['title']  = 'Cetak Rekap Porsi';

        return view('rekap_porsi/print', $data);
    }

    public function exportExcel($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $items = $this->itemModel->where('rekap_porsi_id', $id)->findAll();

        $days = ['Sunday'=>'MINGGU','Monday'=>'SENIN','Tuesday'=>'SELASA','Wednesday'=>'RABU','Thursday'=>'KAMIS','Friday'=>'JUMAT','Saturday'=>'SABTU'];
        $months = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        
        $hari_tgl = $days[date('l', strtotime($header['tanggal']))] . ' ' . date('d', strtotime($header['tanggal'])) . ' ' . $months[(int)date('m', strtotime($header['tanggal']))] . ' ' . date('Y', strtotime($header['tanggal']));

        $filename = 'Rekap_Porsi_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($output, ['Hari dan TGL', $hari_tgl]);
        fputcsv($output, []);
        fputcsv($output, ['NO', 'TINGKATAN', 'SEKOLAH', 'JUMLAH PM', 'JUMLAH PM Ter DISTRIBUSI', 'Jumlah PM tidak terdistribusi', 'Keterangan', 'Pengalihan']);

        foreach ($items as $i => $item) {
            fputcsv($output, [
                $i + 1,
                $item['tingkatan'],
                $item['sekolah'],
                $item['jumlah_pm'],
                $item['jumlah_terdistribusi'],
                $item['jumlah_tidak_terdistribusi'],
                $item['keterangan'],
                $item['pengalihan']
            ]);
        }

        fclose($output);
        exit;
    }
}
