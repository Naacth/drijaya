<?php

namespace App\Controllers;

use App\Models\UjiOrganoleptikModel;
use App\Models\UjiOrganoleptikItemModel;
use App\Traits\ChecksAslapOwnsRecord;

class UjiOrganoleptikController extends BaseController
{
    use ChecksAslapOwnsRecord;

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
        } elseif ($role == 'admin' || $role == 'pic') {
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
                'waktu_uji'           => $item['waktu_uji'] ?? 'Sebelum Pengantaran',
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

        if ($r = $this->redirectIfAslapCannotAccessRecord($header, '/uji-organoleptik')) {
            return $r;
        }

        $data['header'] = $header;
        $data['items']  = $this->itemModel->where('uji_organoleptik_id', $id)->findAll();
        $data['title']  = 'Detail Uji Organoleptik';

        return view('uji_organoleptik/show', $data);
    }

    public function edit($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('uji_organoleptik');
        $builder->select('uji_organoleptik.*, users.nama as user_nama');
        $builder->join('users', 'users.id = uji_organoleptik.created_by');
        $builder->where('uji_organoleptik.id', $id);
        $header = $builder->get()->getRowArray();

        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if ($r = $this->redirectIfAslapCannotAccessRecord($header, '/uji-organoleptik')) {
            return $r;
        }

        $data['header'] = $header;
        $data['items']  = $this->itemModel->where('uji_organoleptik_id', $id)->findAll();
        $data['title']  = 'Ubah Checklist Uji Organoleptik';

        return view('uji_organoleptik/edit', $data);
    }

    public function update($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if ($r = $this->redirectIfAslapCannotAccessRecord($header, '/uji-organoleptik')) {
            return $r;
        }

        $items = $this->request->getPost('items');
        if (empty($items)) {
            return redirect()->back()->with('error', 'Minimal harus mengisi 1 baris nama makan.')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->headerModel->update($id, [
            'nama_pemeriksa'      => $this->request->getPost('nama_pemeriksa'),
            'tempat_pemeriksaan'  => $this->request->getPost('tempat_pemeriksaan'),
            'nama_tempat'         => $this->request->getPost('nama_tempat'),
            'tanggal_pemeriksaan' => $this->request->getPost('tanggal_pemeriksaan'),
            'waktu_pemeriksaan'   => $this->request->getPost('waktu_pemeriksaan'),
            'nama_aslap'          => $this->request->getPost('nama_aslap'),
            'nama_pemeriksa_plok' => $this->request->getPost('nama_pemeriksa_plok'),
            'nama_kepala_sppg'    => $this->request->getPost('nama_kepala_sppg'),
        ]);

        $this->itemModel->where('uji_organoleptik_id', $id)->delete();

        foreach ($items as $item) {
            $this->itemModel->insert([
                'uji_organoleptik_id' => $id,
                'nama_makan'          => $item['nama_makan'],
                'waktu_uji'           => $item['waktu_uji'] ?? 'Sebelum Pengantaran',
                'skor_rasa'           => $item['skor_rasa'],
                'skor_warna'          => $item['skor_warna'],
                'skor_aroma'          => $item['skor_aroma'],
                'skor_tekstur'        => $item['skor_tekstur'],
                'keterangan'          => $item['keterangan'] ?? '',
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memperbarui data.')->withInput();
        }

        return redirect()->to('/uji-organoleptik/show/' . $id)->with('success', 'Checklist berhasil diperbarui.');
    }

    public function exportPdf($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data['header'] = $header;
        $data['items']  = $this->itemModel->where('uji_organoleptik_id', $id)->findAll();
        $data['title']  = 'Cetak Uji Organoleptik';
        $data['signature'] = signature_row_for_pdf(isset($header['created_by']) ? (int) $header['created_by'] : null);

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

        fputcsv($output, ['No', 'Nama Makan', 'Waktu Uji', 'Rasa (1-5)', 'Warna (1-5)', 'Aroma (1-5)', 'Tekstur (1-5)', 'Keterangan']);

        foreach ($items as $index => $item) {
            fputcsv($output, [
                $index + 1,
                $item['nama_makan'],
                $item['waktu_uji'] ?? '',
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
    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }

        $db = \Config\Database::connect();
        $db->transStart();
        $this->itemModel->where('uji_organoleptik_id', $id)->delete();
        $this->headerModel->delete($id);
        $db->transComplete();

        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal menghapus data.');
        return redirect()->to('/uji-organoleptik')->with('success', 'Data berhasil dihapus.');
    }
}
