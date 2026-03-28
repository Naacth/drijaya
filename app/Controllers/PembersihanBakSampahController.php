<?php

namespace App\Controllers;

use App\Models\PembersihanBakSampahModel;

class PembersihanBakSampahController extends BaseController
{
    protected $model;
    public function __construct() { $this->model = new PembersihanBakSampahModel(); }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pembersihan_bak_sampah');
        $builder->select('pembersihan_bak_sampah.*, users.nama as user_nama');
        $builder->join('users', 'users.id = pembersihan_bak_sampah.created_by');
        $role = session()->get('role');
        if ($role == 'ahli_gizi') $builder->where('pembersihan_bak_sampah.created_by', session()->get('user_id'));
        elseif ($role == 'admin') { $s = session()->get('sppg_id'); if ($s) $builder->where('users.sppg_id', $s); }
        $builder->orderBy('pembersihan_bak_sampah.created_at', 'DESC');
        return view('pembersihan_bak_sampah/index', ['title' => 'Pembersihan Bak Sampah', 'forms' => $builder->get()->getResultArray()]);
    }

    public function create() { return view('pembersihan_bak_sampah/create', ['title' => 'Buat Form Pembersihan Bak Sampah']); }

    public function store()
    {
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_personil' => $this->request->getPost('nama_personil'),
            'jam' => $this->request->getPost('jam'),
            'keterangan' => $this->request->getPost('keterangan'),
            'created_by' => session()->get('user_id'),
        ];
        $this->model->insert($data);
        return redirect()->to('/pembersihan-bak-sampah')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $form = $this->model->find($id);
        return view('pembersihan_bak_sampah/show', ['title' => 'Detail Pembersihan Bak Sampah', 'header' => $form]);
    }

    public function exportPdf($id)
    {
        $form = $this->model->find($id);
        $data = [
            'header' => $form, 'title' => 'Cetak Bak Sampah',
            'signature' => (new \App\Models\UserSignatureModel())->where('user_id', $form['created_by'])->first()
        ];
        return view('pembersihan_bak_sampah/print', $data);
    }

    public function exportExcel($id)
    {
        $form = $this->model->find($id);
        header('Content-Type: text/csv'); header('Content-Disposition: attachment; filename=Bak_Sampah.csv');
        $o = fopen('php://output', 'w'); fputcsv($o, ['PEMBERSIHAN BAK SAMPAH']);
        fputcsv($o, ['Tanggal', $form['tanggal']]); fputcsv($o, ['Jam', $form['jam']]);
        fputcsv($o, ['Personil', $form['nama_personil']]); fputcsv($o, ['Keterangan', $form['keterangan']]);
        fclose($o); exit;
    }

    public function edit($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('pembersihan_bak_sampah/edit', ['title' => 'Edit Pembersihan Bak Sampah', 'header' => $form]);
    }

    public function update($id)
    {
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_personil' => $this->request->getPost('nama_personil'),
            'jam' => $this->request->getPost('jam'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];
        $this->model->update($id, $data);
        return redirect()->to('/pembersihan-bak-sampah')->with('success', 'Data berhasil diperbarui.');
    }
}
