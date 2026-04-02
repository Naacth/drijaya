<?php

namespace App\Controllers;

use App\Traits\ChecksAhliGiziOwnership;
use App\Models\EstimasiAnggaranModel;
use App\Models\EstimasiAnggaranItemModel;

class EstimasiAnggaranController extends BaseController
{
    use ChecksAhliGiziOwnership;

    protected $headerModel;
    protected $itemModel;

    public function __construct()
    {
        $this->headerModel = new EstimasiAnggaranModel();
        $this->itemModel   = new EstimasiAnggaranItemModel();
    }

    public function index()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('estimasi_anggaran');
        $builder->select('estimasi_anggaran.*, users.nama as user_nama');
        $builder->join('users', 'users.id = estimasi_anggaran.created_by');

        $role   = session()->get('role');
        $userId = session()->get('user_id');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $builder->where('estimasi_anggaran.created_by', $userId);
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $builder->where('users.sppg_id', $sppgId);
        }

        $builder->orderBy('estimasi_anggaran.created_at', 'DESC');
        $data['title'] = 'Estimasi Anggaran (Menu Kering)';
        $data['forms'] = $builder->get()->getResultArray();
        return view('estimasi_anggaran/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Buat Estimasi Anggaran';
        return view('estimasi_anggaran/create', $data);
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
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'kategori_porsi'  => $this->request->getPost('kategori_porsi'),
            'total_kalkulasi' => $this->request->getPost('total_kalkulasi'),
            'sppg_id'         => session()->get('sppg_id'),
            'created_by'      => session()->get('user_id'),
        ]);

        foreach ($items as $item) {
            $this->itemModel->insert([
                'estimasi_anggaran_id' => $headerId,
                'nama_item'            => $item['nama_item'],
                'harga_satuan'         => $item['harga_satuan'] ?? 0,
            ]);
        }

        $db->transComplete();
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan data.')->withInput();
        }
        return redirect()->to('/estimasi-anggaran')->with('success', 'Data Estimasi Anggaran berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('estimasi_anggaran');
        $builder->select('estimasi_anggaran.*, users.nama as user_nama');
        $builder->join('users', 'users.id = estimasi_anggaran.created_by');
        $builder->where('estimasi_anggaran.id', $id);
        $header = $builder->get()->getRowArray();
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($header, '/estimasi-anggaran')) {
            return $r;
        }

        $data['header'] = $header;
        $data['items']  = $this->itemModel->where('estimasi_anggaran_id', $id)->findAll();
        $data['title']  = 'Detail Estimasi Anggaran';
        return view('estimasi_anggaran/show', $data);
    }

    public function edit($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($header, '/estimasi-anggaran')) {
            return $r;
        }

        $data = [
            'header' => $header,
            'items'  => $this->itemModel->where('estimasi_anggaran_id', $id)->findAll(),
            'title'  => 'Edit Estimasi Anggaran'
        ];
        return view('estimasi_anggaran/edit', $data);
    }

    public function update($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($header, '/estimasi-anggaran')) {
            return $r;
        }

        $items = $this->request->getPost('items');
        if (empty($items)) {
            return redirect()->back()->with('error', 'Minimal harus mengisi 1 baris.')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->headerModel->update($id, [
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'kategori_porsi'  => $this->request->getPost('kategori_porsi'),
            'total_kalkulasi' => $this->request->getPost('total_kalkulasi'),
        ]);

        $this->itemModel->where('estimasi_anggaran_id', $id)->delete();
        foreach ($items as $item) {
            $this->itemModel->insert([
                'estimasi_anggaran_id' => $id,
                'nama_item'            => $item['nama_item'],
                'harga_satuan'         => $item['harga_satuan'] ?? 0,
            ]);
        }

        $db->transComplete();
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memperbarui data.')->withInput();
        }
        return redirect()->to('/estimasi-anggaran')->with('success', 'Data Estimasi Anggaran berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }

        $db = \Config\Database::connect();
        $db->transStart();
        
        $this->itemModel->where('estimasi_anggaran_id', $id)->delete();
        $this->headerModel->delete($id);

        $db->transComplete();
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menghapus data.');
        }

        return redirect()->to('/estimasi-anggaran')->with('success', 'Data Estimasi Anggaran berhasil dihapus.');
    }

    public function exportPdf($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('estimasi_anggaran');
        $builder->select('estimasi_anggaran.*, users.nama as user_nama, users.id as user_id');
        $builder->join('users', 'users.id = estimasi_anggaran.created_by');
        $builder->where('estimasi_anggaran.id', $id);
        $header = $builder->get()->getRowArray();

        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        
        $data['header']    = $header;
        $data['items']     = $this->itemModel->where('estimasi_anggaran_id', $id)->findAll();
        $data['title']     = 'Cetak Estimasi Anggaran';
        return view('estimasi_anggaran/print', $data);
    }

    public function exportExcel($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $items = $this->itemModel->where('estimasi_anggaran_id', $id)->findAll();

        $filename = 'Estimasi_Anggaran_' . date('Ymd') . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ESTIMASI ANGGARAN (MENU KERING)']);
        fputcsv($output, ['Periode', $header['tanggal_mulai'] . ' - ' . $header['tanggal_selesai']]);
        fputcsv($output, ['Kategori', $header['kategori_porsi']]);
        fputcsv($output, []);
        fputcsv($output, ['No', 'Nama Item', 'Harga Satuan (Rp)']);
        foreach ($items as $i => $item) {
            fputcsv($output, [$i + 1, $item['nama_item'], $item['harga_satuan']]);
        }
        fputcsv($output, ['', 'TOTAL', $header['total_kalkulasi']]);
        fclose($output);
        exit;
    }
}
