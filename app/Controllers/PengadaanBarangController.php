<?php

namespace App\Controllers;

use App\Models\PengadaanBarangModel;

class PengadaanBarangController extends BaseController
{
    protected $model;
    public function __construct() { $this->model = new PengadaanBarangModel(); }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pengadaan_barang');
        $builder->select('pengadaan_barang.*, users.nama as user_nama');
        $builder->join('users', 'users.id = pengadaan_barang.created_by');
        $role = session()->get('role');
        if ($role == 'admin' || $role == 'pic') {
            $s = session()->get('sppg_id');
            if ($s) $builder->where('users.sppg_id', $s);
        }
        $builder->orderBy('pengadaan_barang.created_at', 'DESC');
        return view('pengadaan_barang/index', ['title' => 'Pengadaan Barang', 'forms' => $builder->get()->getResultArray()]);
    }

    public function create() { return view('pengadaan_barang/create', ['title' => 'Buat Pengajuan Pengadaan Barang']); }

    public function store()
    {
        $data = [
            'tanggal'         => $this->request->getPost('tanggal'),
            'nama_barang'     => $this->request->getPost('nama_barang'),
            'jumlah'          => $this->request->getPost('jumlah'),
            'satuan'          => $this->request->getPost('satuan'),
            'estimasi_harga'  => $this->request->getPost('estimasi_harga'),
            'alasan'          => $this->request->getPost('alasan'),
            'status'          => $this->request->getPost('status') ?: 'draft',
            'created_by'      => session()->get('user_id'),
        ];
        $this->model->insert($data);
        return redirect()->to('/pengadaan-barang')->with('success', 'Pengajuan pengadaan barang berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pengadaan_barang');
        $builder->select('pengadaan_barang.*, users.nama as user_nama');
        $builder->join('users', 'users.id = pengadaan_barang.created_by');
        $builder->where('pengadaan_barang.id', $id);
        $form = $builder->get()->getRowArray();
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('pengadaan_barang/show', ['title' => 'Detail Pengadaan Barang', 'header' => $form]);
    }

    public function edit($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('pengadaan_barang/edit', ['title' => 'Edit Pengadaan Barang', 'header' => $form]);
    }

    public function update($id)
    {
        $data = [
            'tanggal'         => $this->request->getPost('tanggal'),
            'nama_barang'     => $this->request->getPost('nama_barang'),
            'jumlah'          => $this->request->getPost('jumlah'),
            'satuan'          => $this->request->getPost('satuan'),
            'estimasi_harga'  => $this->request->getPost('estimasi_harga'),
            'alasan'          => $this->request->getPost('alasan'),
            'status'          => $this->request->getPost('status') ?: 'draft',
        ];
        $this->model->update($id, $data);
        return redirect()->to('/pengadaan-barang')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }
        $this->model->delete($id);
        return redirect()->to('/pengadaan-barang')->with('success', 'Data berhasil dihapus.');
    }

    public function exportPdf($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $db = \Config\Database::connect();
        $user = $db->table('users')->where('id', $form['created_by'])->get()->getRowArray();
        return view('pengadaan_barang/print', ['header' => $form, 'title' => 'Cetak Pengadaan Barang', 'user_nama' => $user['nama'] ?? '-']);
    }

    public function exportExcel($id)
    {
        $form = $this->model->find($id);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=Pengadaan_Barang.csv');
        $o = fopen('php://output', 'w');
        fputcsv($o, ['PENGADAAN BARANG']);
        fputcsv($o, ['Tanggal', $form['tanggal']]);
        fputcsv($o, ['Nama Barang', $form['nama_barang']]);
        fputcsv($o, ['Jumlah', $form['jumlah'] . ' ' . $form['satuan']]);
        fputcsv($o, ['Estimasi Harga', $form['estimasi_harga']]);
        fputcsv($o, ['Alasan', $form['alasan']]);
        fputcsv($o, ['Status', $form['status']]);
        fclose($o);
        exit;
    }

    public function approve($id)
    {
        if (session()->get('role') !== 'admin') return redirect()->back()->with('error', 'Akses ditolak.');
        $this->model->update($id, ['status' => 'disetujui']);
        return redirect()->to('/pengadaan-barang')->with('success', 'Pengajuan disetujui.');
    }

    public function reject($id)
    {
        if (session()->get('role') !== 'admin') return redirect()->back()->with('error', 'Akses ditolak.');
        $this->model->update($id, ['status' => 'ditolak']);
        return redirect()->to('/pengadaan-barang')->with('success', 'Pengajuan ditolak.');
    }
}
