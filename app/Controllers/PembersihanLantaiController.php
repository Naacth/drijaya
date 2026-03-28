<?php

namespace App\Controllers;

use App\Models\PembersihanLantaiModel;

class PembersihanLantaiController extends BaseController
{
    protected $model;
    public function __construct() { $this->model = new PembersihanLantaiModel(); }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pembersihan_lantai');
        $builder->select('pembersihan_lantai.*, users.nama as user_nama');
        $builder->join('users', 'users.id = pembersihan_lantai.created_by');
        $role = session()->get('role');
        if ($role == 'ahli_gizi') $builder->where('pembersihan_lantai.created_by', session()->get('user_id'));
        elseif ($role == 'admin') { $s = session()->get('sppg_id'); if ($s) $builder->where('users.sppg_id', $s); }
        $builder->orderBy('pembersihan_lantai.created_at', 'DESC');
        return view('pembersihan_lantai/index', ['title' => 'Pembersihan Lantai', 'forms' => $builder->get()->getResultArray()]);
    }

    public function create() { return view('pembersihan_lantai/create', ['title' => 'Buat Form Pembersihan Lantai']); }

    public function store()
    {
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_personil' => $this->request->getPost('nama_personil'),
            'jam' => $this->request->getPost('jam'),
            'kondisi' => $this->request->getPost('kondisi'),
            'created_by' => session()->get('user_id'),
        ];
        $this->model->insert($data);
        return redirect()->to('/pembersihan-lantai')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $form = $this->model->find($id);
        return view('pembersihan_lantai/show', ['title' => 'Detail Pembersihan Lantai', 'header' => $form]);
    }

    public function exportPdf($id)
    {
        $form = $this->model->find($id);
        $data = [
            'header' => $form, 'title' => 'Cetak Pembersihan Lantai',
            'signature' => (new \App\Models\UserSignatureModel())->where('user_id', $form['created_by'])->first()
        ];
        return view('pembersihan_lantai/print', $data);
    }

    public function exportExcel($id)
    {
        $form = $this->model->find($id);
        header('Content-Type: text/csv'); header('Content-Disposition: attachment; filename=Lantai.csv');
        $o = fopen('php://output', 'w'); fputcsv($o, ['PEMBERSIHAN LANTAI']);
        fputcsv($o, ['Tanggal', $form['tanggal']]); fputcsv($o, ['Jam', $form['jam']]);
        fputcsv($o, ['Personil', $form['nama_personil']]); fputcsv($o, ['Kondisi', $form['kondisi']]);
        fclose($o); exit;
    }

    public function edit($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('pembersihan_lantai/edit', ['title' => 'Edit Pembersihan Lantai', 'header' => $form]);
    }

    public function update($id)
    {
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_personil' => $this->request->getPost('nama_personil'),
            'jam' => $this->request->getPost('jam'),
            'kondisi' => $this->request->getPost('kondisi'),
        ];
        $this->model->update($id, $data);
        return redirect()->to('/pembersihan-lantai')->with('success', 'Data berhasil diperbarui.');
    }
}
