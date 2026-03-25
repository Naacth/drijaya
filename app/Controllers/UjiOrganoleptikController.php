<?php

namespace App\Controllers;

use App\Models\UjiOrganoleptikModel;
use App\Models\UjiOrganoleptikItemModel;

class UjiOrganoleptikController extends BaseController
{
    protected $headerModel;
    protected $itemModel;

    public function __construct()
    {
        $this->headerModel = new UjiOrganoleptikModel();
        $this->itemModel   = new UjiOrganoleptikItemModel();
    }

    public function index()
    {
        $role   = session()->get('role');
        $userId = session()->get('user_id');

        $db      = \Config\Database::connect();
        $builder = $db->table('uji_organoleptik');
        $builder->select('uji_organoleptik.*, users.nama as user_nama');
        $builder->join('users', 'users.id = uji_organoleptik.created_by');

        if ($role == 'aslap') {
            $builder->where('uji_organoleptik.created_by', $userId);
        } elseif ($role == 'admin') {
            $currentSppgId = session()->get('sppg_id');
            if ($currentSppgId) {
                $builder->where('users.sppg_id', $currentSppgId);
            }
        }

        $builder->orderBy('uji_organoleptik.created_at', 'DESC');

        $data['title'] = 'Checklist Uji Organoleptik';
        $data['forms'] = $builder->get()->getResultArray();

        return view('uji_organoleptik/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Buat Checklist Uji Organoleptik';
        return view('uji_organoleptik/create', $data);
    }

    public function store()
    {
        $items = $this->request->getPost('items');
        if (empty($items)) {
            return redirect()->back()->with('error', 'Minimal harus mengisi 1 baris nama makan.')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $headerData = [
            'nama_pemeriksa'      => $this->request->getPost('nama_pemeriksa'),
            'tempat_pemeriksaan'  => $this->request->getPost('tempat_pemeriksaan'),
            'nama_tempat'         => $this->request->getPost('nama_tempat'),
            'tanggal_pemeriksaan' => $this->request->getPost('tanggal_pemeriksaan'),
            'waktu_pemeriksaan'   => $this->request->getPost('waktu_pemeriksaan'),
            'waktu_uji'           => $this->request->getPost('waktu_uji'),
            'nama_aslap'          => $this->request->getPost('nama_aslap'),
            'nama_pemeriksa_plok' => $this->request->getPost('nama_pemeriksa_plok'),
            'nama_kepala_sppg'    => $this->request->getPost('nama_kepala_sppg'),
            'created_by'          => session()->get('user_id'),
        ];

        $headerId = $this->headerModel->insert($headerData);

        foreach ($items as $item) {
            $this->itemModel->insert([
                'uji_organoleptik_id' => $headerId,
                'nama_makan'          => $item['nama_makan'],
                'skor_rasa'           => $item['skor_rasa'],
                'skor_warna'          => $item['skor_warna'],
                'skor_aroma'          => $item['skor_aroma'],
                'skor_tekstur'        => $item['skor_tekstur'],
                'keterangan'          => $item['keterangan'] ?? '',
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan data.')->withInput();
        }

        return redirect()->to('/uji-organoleptik')->with('success', 'Checklist Uji Organoleptik berhasil disimpan.');
    }

    public function show($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('uji_organoleptik');
        $builder->select('uji_organoleptik.*, users.nama as user_nama');
        $builder->join('users', 'users.id = uji_organoleptik.created_by');
        $builder->where('uji_organoleptik.id', $id);
        $header = $builder->get()->getRowArray();

        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data['header'] = $header;
        $data['items']  = $this->itemModel->where('uji_organoleptik_id', $id)->findAll();
        $data['title']  = 'Detail Uji Organoleptik';

        return view('uji_organoleptik/show', $data);
    }

    public function exportPdf($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data['header'] = $header;
        $data['items']  = $this->itemModel->where('uji_organoleptik_id', $id)->findAll();
        $data['title']  = 'Cetak Uji Organoleptik';
        $data['signature'] = (new \App\Models\UserSignatureModel())->where('user_id', $header['created_by'])->first();

        return view('uji_organoleptik/print', $data);
    }

    public function exportExcel($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $items = $this->itemModel->where('uji_organoleptik_id', $id)->findAll();

        $filename = 'Uji_Organoleptik_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($output, ['CHECKLIST UJI ORGANOLEPTIK']);
        fputcsv($output, ['Nama Pemeriksa', $header['nama_pemeriksa']]);
        fputcsv($output, ['Tempat', $header['tempat_pemeriksaan'] . ' - ' . $header['nama_tempat']]);
        fputcsv($output, ['Tanggal', $header['tanggal_pemeriksaan']]);
        fputcsv($output, ['Waktu', $header['waktu_pemeriksaan']]);
        fputcsv($output, []);

        fputcsv($output, ['No', 'Nama Makan', 'Rasa (1-5)', 'Warna (1-5)', 'Aroma (1-5)', 'Tekstur (1-5)', 'Keterangan']);

        foreach ($items as $index => $item) {
            fputcsv($output, [
                $index + 1,
                $item['nama_makan'],
                $item['skor_rasa'],
                $item['skor_warna'],
                $item['skor_aroma'],
                $item['skor_tekstur'],
                $item['keterangan'],
            ]);
        }

        fclose($output);
        exit;
    }
}
