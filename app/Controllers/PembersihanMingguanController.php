<?php

namespace App\Controllers;

use App\Traits\ChecksAhliGiziOwnership;
use App\Models\PembersihanMingguanModel;

class PembersihanMingguanController extends BaseController
{
    use ChecksAhliGiziOwnership;

    protected $model;
    public function __construct() { $this->model = new PembersihanMingguanModel(); }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pembersihan_mingguan');
        $builder->select('pembersihan_mingguan.*, users.nama as user_nama');
        $builder->join('users', 'users.id = pembersihan_mingguan.created_by');
        $role = session()->get('role');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $builder->where('pembersihan_mingguan.created_by', session()->get('user_id'));
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $builder->where('users.sppg_id', $sppgId);
        }
        $builder->orderBy('pembersihan_mingguan.created_at', 'DESC');
        return view('pembersihan_mingguan/index', ['title' => 'Pembersihan Freezer & Chiller (Mingguan)', 'forms' => $builder->get()->getResultArray()]);
    }

    public function create() { return view('pembersihan_mingguan/create', ['title' => 'Buat Form Pembersihan Mingguan']); }

    public function store()
    {
        $data = [
            'area_pencucian' => $this->request->getPost('area_pencucian'),
            'minggu_ke' => $this->request->getPost('minggu_ke'),
            'bulan' => $this->request->getPost('bulan'),
            'checklist_data' => json_encode($this->request->getPost('checklist')),
            'nama_verifikator' => $this->request->getPost('nama_verifikator'),
            'created_by' => session()->get('user_id'),
        ];
        $this->model->insert($data);
        return redirect()->to('/pembersihan-mingguan')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/pembersihan-mingguan')) {
            return $r;
        }
        return view('pembersihan_mingguan/show', ['title' => 'Detail Pembersihan Mingguan', 'header' => $form, 'checklist' => json_decode($form['checklist_data'], true)]);
    }

    public function exportPdf($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('pembersihan_mingguan/print', [
            'header' => $form, 'checklist' => json_decode($form['checklist_data'], true), 'title' => 'Cetak Mingguan'
        ]);
    }

    public function exportExcel($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $checklist = json_decode($form['checklist_data'], true);
        header('Content-Type: text/csv'); header('Content-Disposition: attachment; filename=Mingguan.csv');
        $o = fopen('php://output', 'w'); fputcsv($o, ['PEMBERSIHAN MINGGUAN', strtoupper($form['area_pencucian'])]);
        fputcsv($o, ['Bulan', $form['bulan']]); fputcsv($o, ['Minggu Ke', $form['minggu_ke']]); fputcsv($o, []);
        fputcsv($o, ['Komponen', 'Status']);
        foreach ($checklist as $k => $v) fputcsv($o, [ucfirst(str_replace('_', ' ', $k)), $v]);
        fclose($o); exit;
    }

    public function edit($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/pembersihan-mingguan')) {
            return $r;
        }
        return view('pembersihan_mingguan/edit', [
            'title' => 'Edit Pembersihan Mingguan', 
            'header' => $form, 
            'checklist' => json_decode($form['checklist_data'], true)
        ]);
    }

    public function update($id)
    {
        $form = $this->model->find($id);
        if (!$form) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/pembersihan-mingguan')) {
            return $r;
        }

        $data = [
            'area_pencucian' => $this->request->getPost('area_pencucian'),
            'minggu_ke' => $this->request->getPost('minggu_ke'),
            'bulan' => $this->request->getPost('bulan'),
            'checklist_data' => json_encode($this->request->getPost('checklist')),
            'nama_verifikator' => $this->request->getPost('nama_verifikator'),
        ];
        $this->model->update($id, $data);
        return redirect()->to('/pembersihan-mingguan')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }
        $this->model->delete($id);
        return redirect()->to('/pembersihan-mingguan')->with('success', 'Data berhasil dihapus.');
    }
}
