<?php

namespace App\Controllers;

use App\Models\PengajuanBarangRusakModel;

class PengajuanBarangRusakController extends BaseController
{
    protected $model;
    public function __construct() { $this->model = new PengajuanBarangRusakModel(); }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pengajuan_barang_rusak');
        $builder->select('pengajuan_barang_rusak.*, users.nama as user_nama');
        $builder->join('users', 'users.id = pengajuan_barang_rusak.created_by');
        $role = session()->get('role');
        if ($role == 'pic' || $role == 'admin') { 
            $s = session()->get('sppg_id'); 
            if ($s) $builder->where('users.sppg_id', $s); 
        }
        $builder->orderBy('pengajuan_barang_rusak.created_at', 'DESC');
        return view('pengajuan_barang_rusak/index', ['title' => 'Pengajuan Barang Rusak', 'forms' => $builder->get()->getResultArray()]);
    }

    public function create() { return view('pengajuan_barang_rusak/create', ['title' => 'Buat Pengajuan Barang Rusak']); }

    public function store()
    {
        $data = [
            'tanggal'     => $this->request->getPost('tanggal'),
            'nama_barang' => $this->request->getPost('nama_barang'),
            'jumlah'      => $this->request->getPost('jumlah'),
            'satuan'      => $this->request->getPost('satuan'),
            'kondisi'     => $this->request->getPost('kondisi'),
            'keterangan'  => $this->request->getPost('keterangan'),
            'status'      => $this->request->getPost('status') ?: 'draft',
            'created_by'  => session()->get('user_id'),
        ];

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $newName = 'barang_rusak_' . time() . '.' . $foto->getExtension();
            $foto->move('uploads/barang_rusak', $newName);
            $data['foto'] = 'uploads/barang_rusak/' . $newName;
        }

        $this->model->insert($data);
        return redirect()->to('/pengajuan-barang-rusak')->with('success', 'Pengajuan barang rusak berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pengajuan_barang_rusak');
        $builder->select('pengajuan_barang_rusak.*, users.nama as user_nama');
        $builder->join('users', 'users.id = pengajuan_barang_rusak.created_by');
        $builder->where('pengajuan_barang_rusak.id', $id);
        $form = $builder->get()->getRowArray();
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('pengajuan_barang_rusak/show', ['title' => 'Detail Pengajuan Barang Rusak', 'header' => $form]);
    }

    public function edit($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('pengajuan_barang_rusak/edit', ['title' => 'Edit Pengajuan Barang Rusak', 'header' => $form]);
    }

    public function update($id)
    {
        $data = [
            'tanggal'     => $this->request->getPost('tanggal'),
            'nama_barang' => $this->request->getPost('nama_barang'),
            'jumlah'      => $this->request->getPost('jumlah'),
            'satuan'      => $this->request->getPost('satuan'),
            'kondisi'     => $this->request->getPost('kondisi'),
            'keterangan'  => $this->request->getPost('keterangan'),
            'status'      => $this->request->getPost('status') ?: 'draft',
        ];

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $newName = 'barang_rusak_' . time() . '.' . $foto->getExtension();
            $foto->move('uploads/barang_rusak', $newName);
            $data['foto'] = 'uploads/barang_rusak/' . $newName;
        }

        $this->model->update($id, $data);
        return redirect()->to('/pengajuan-barang-rusak')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }
        $this->model->delete($id);
        return redirect()->to('/pengajuan-barang-rusak')->with('success', 'Data berhasil dihapus.');
    }

    public function exportPdf($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $db = \Config\Database::connect();
        $user = $db->table('users')->where('id', $form['created_by'])->get()->getRowArray();
        return view('pengajuan_barang_rusak/print', ['header' => $form, 'title' => 'Cetak Pengajuan Barang Rusak', 'user_nama' => $user['nama'] ?? '-']);
    }

    public function exportExcel($id)
    {
        $form = $this->model->find($id);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=Pengajuan_Barang_Rusak.csv');
        $o = fopen('php://output', 'w');
        fputcsv($o, ['PENGAJUAN BARANG RUSAK']);
        fputcsv($o, ['Tanggal', $form['tanggal']]);
        fputcsv($o, ['Nama Barang', $form['nama_barang']]);
        fputcsv($o, ['Jumlah', $form['jumlah'] . ' ' . $form['satuan']]);
        fputcsv($o, ['Kondisi', $form['kondisi']]);
        fputcsv($o, ['Keterangan', $form['keterangan']]);
        fputcsv($o, ['Status', $form['status']]);
        fclose($o);
        exit;
    }

    public function approve($id)
    {
        if (session()->get('role') !== 'admin') return redirect()->back()->with('error', 'Akses ditolak.');
        $this->model->update($id, ['status' => 'disetujui']);
        return redirect()->to('/pengajuan-barang-rusak')->with('success', 'Pengajuan disetujui.');
    }

    public function reject($id)
    {
        if (session()->get('role') !== 'admin') return redirect()->back()->with('error', 'Akses ditolak.');
        $this->model->update($id, ['status' => 'ditolak']);
        return redirect()->to('/pengajuan-barang-rusak')->with('success', 'Pengajuan ditolak.');
    }
}
