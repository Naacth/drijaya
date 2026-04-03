<?php

namespace App\Controllers;

use App\Traits\ChecksAhliGiziOwnership;
use App\Models\PembersihanBakSampahModel;

class PembersihanBakSampahController extends BaseController
{
    use ChecksAhliGiziOwnership;

    protected $model;
    public function __construct() { $this->model = new PembersihanBakSampahModel(); }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pembersihan_bak_sampah');
        $builder->select('pembersihan_bak_sampah.*, users.nama as user_nama');
        $builder->join('users', 'users.id = pembersihan_bak_sampah.created_by');
        $role = session()->get('role');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $builder->where('pembersihan_bak_sampah.created_by', session()->get('user_id'));
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $builder->where('users.sppg_id', $sppgId);
        }
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
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/pembersihan-bak-sampah')) {
            return $r;
        }
        return view('pembersihan_bak_sampah/show', ['title' => 'Detail Pembersihan Bak Sampah', 'header' => $form]);
    }

    public function exportPdf($id)
    {
        $form = $this->model->find($id);
        $data = [
            'header' => $form, 'title' => 'Cetak Bak Sampah',
            'signature' => signature_row_for_pdf(isset($form['created_by']) ? (int) $form['created_by'] : null)
        ];
        return view('pembersihan_bak_sampah/print', $data);
    }

    public function exportPdfBlank()
    {
        helper('print');

        return view('pembersihan_bak_sampah/print', [
            'blank'     => true,
            'header'    => ['tanggal' => '', 'nama_personil' => '', 'jam' => '', 'keterangan' => '', 'created_by' => null],
            'title'     => 'Form Pembersihan Bak Sampah (kosong)',
            'signature' => signature_row_for_pdf(null),
        ]);
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
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/pembersihan-bak-sampah')) {
            return $r;
        }
        return view('pembersihan_bak_sampah/edit', ['title' => 'Edit Pembersihan Bak Sampah', 'header' => $form]);
    }

    public function update($id)
    {
        $form = $this->model->find($id);
        if (!$form) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/pembersihan-bak-sampah')) {
            return $r;
        }

        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_personil' => $this->request->getPost('nama_personil'),
            'jam' => $this->request->getPost('jam'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];
        $this->model->update($id, $data);
        return redirect()->to('/pembersihan-bak-sampah')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }
        $this->model->delete($id);
        return redirect()->to('/pembersihan-bak-sampah')->with('success', 'Data berhasil dihapus.');
    }
}
