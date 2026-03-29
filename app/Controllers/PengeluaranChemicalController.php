<?php

namespace App\Controllers;

use App\Models\PengeluaranChemicalModel;

class PengeluaranChemicalController extends BaseController
{
    protected $model;
    public function __construct() { $this->model = new PengeluaranChemicalModel(); }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pengeluaran_chemical');
        $builder->select('pengeluaran_chemical.*, users.nama as user_nama');
        $builder->join('users', 'users.id = pengeluaran_chemical.created_by');
        $role = session()->get('role');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $builder->where('pengeluaran_chemical.created_by', session()->get('user_id'));
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $builder->where('users.sppg_id', $sppgId);
        }
        $builder->orderBy('pengeluaran_chemical.created_at', 'DESC');
        return view('pengeluaran_chemical/index', ['title' => 'Pengeluaran Bahan Kimia (Chemical)', 'forms' => $builder->get()->getResultArray()]);
    }

    public function create() { return view('pengeluaran_chemical/create', ['title' => 'Buat Form Pengeluaran Chemical']); }

    public function store()
    {
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_chemical' => $this->request->getPost('nama_chemical'),
            'jumlah' => $this->request->getPost('jumlah'),
            'unit' => $this->request->getPost('unit'),
            'nama_personil' => $this->request->getPost('nama_personil'),
            'nama_gizi' => $this->request->getPost('nama_gizi'),
            'created_by' => session()->get('user_id'),
        ];
        $this->model->insert($data);
        return redirect()->to('/pengeluaran-chemical')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $form = $this->model->find($id);
        return view('pengeluaran_chemical/show', ['title' => 'Detail Pengeluaran Chemical', 'header' => $form]);
    }

    public function exportPdf($id)
    {
        $form = $this->model->find($id);
        return view('pengeluaran_chemical/print', [
            'header' => $form, 'title' => 'Cetak Pengeluaran Chemical',
            'signature' => (new \App\Models\UserSignatureModel())->where('user_id', $form['created_by'])->first()
        ]);
    }

    public function exportExcel($id)
    {
        $form = $this->model->find($id);
        header('Content-Type: text/csv'); header('Content-Disposition: attachment; filename=Chemical.csv');
        $o = fopen('php://output', 'w'); fputcsv($o, ['PENGELUARAN CHEMICAL']);
        fputcsv($o, ['Tanggal', $form['tanggal']]); fputcsv($o, ['Nama Chemical', $form['nama_chemical']]);
        fputcsv($o, ['Jumlah', $form['jumlah'] . ' ' . $form['unit']]); fputcsv($o, ['Personil', $form['nama_personil']]);
        fclose($o); exit;
    }

    public function edit($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('pengeluaran_chemical/edit', ['title' => 'Edit Pengeluaran Chemical', 'header' => $form]);
    }

    public function update($id)
    {
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_chemical' => $this->request->getPost('nama_chemical'),
            'jumlah' => $this->request->getPost('jumlah'),
            'unit' => $this->request->getPost('unit'),
            'nama_personil' => $this->request->getPost('nama_personil'),
            'nama_gizi' => $this->request->getPost('nama_gizi'),
        ];
        $this->model->update($id, $data);
        return redirect()->to('/pengeluaran-chemical')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }
        $this->model->delete($id);
        return redirect()->to('/pengeluaran-chemical')->with('success', 'Data berhasil dihapus.');
    }
}
