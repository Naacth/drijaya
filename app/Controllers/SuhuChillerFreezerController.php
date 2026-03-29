<?php

namespace App\Controllers;

use App\Models\SuhuChillerFreezerModel;

class SuhuChillerFreezerController extends BaseController
{
    protected $model;

    public function __construct() { $this->model = new SuhuChillerFreezerModel(); }

    public function index()
    {
        $db = \Config\Database::connect();
        $b = $db->table('suhu_chiller_freezer');
        $b->select('suhu_chiller_freezer.*, users.nama as user_nama');
        $b->join('users', 'users.id = suhu_chiller_freezer.created_by');
        $role = session()->get('role');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $b->where('suhu_chiller_freezer.created_by', session()->get('user_id'));
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $b->where('users.sppg_id', $sppgId);
        }
        $b->orderBy('suhu_chiller_freezer.created_at', 'DESC');
        return view('suhu_chiller_freezer/index', [
            'title' => 'Suhu Chiller & Freezer',
            'forms' => $b->get()->getResultArray()
        ]);
    }

    public function create()
    {
        return view('suhu_chiller_freezer/create', ['title' => 'Input Suhu Chiller & Freezer']);
    }

    public function store()
    {
        $this->model->insert([
            'tanggal'        => $this->request->getPost('tanggal'),
            'chiller_pagi'   => $this->request->getPost('chiller_pagi'),
            'chiller_siang'  => $this->request->getPost('chiller_siang'),
            'chiller_malam'  => $this->request->getPost('chiller_malam'),
            'freezer_pagi'   => $this->request->getPost('freezer_pagi'),
            'freezer_siang'  => $this->request->getPost('freezer_siang'),
            'freezer_malam'  => $this->request->getPost('freezer_malam'),
            'kebersihan_rak' => $this->request->getPost('kebersihan_rak'),
            'verifikasi'     => $this->request->getPost('verifikasi'),
            'nama_petugas'   => $this->request->getPost('nama_petugas'),
            'created_by'     => session()->get('user_id'),
        ]);
        return redirect()->to('/suhu-chiller-freezer')->with('success', 'Data suhu berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect();
        $b = $db->table('suhu_chiller_freezer');
        $b->select('suhu_chiller_freezer.*, users.nama as user_nama');
        $b->join('users', 'users.id = suhu_chiller_freezer.created_by');
        $b->where('suhu_chiller_freezer.id', $id);
        $header = $b->get()->getRowArray();
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('suhu_chiller_freezer/show', ['header' => $header, 'title' => 'Detail Suhu Chiller & Freezer']);
    }

    public function exportPdf($id)
    {
        $header = $this->model->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $sig = (new \App\Models\UserSignatureModel())->where('user_id', $header['created_by'])->first();
        return view('suhu_chiller_freezer/print', ['header' => $header, 'title' => 'Cetak Suhu Chiller & Freezer', 'signature' => $sig]);
    }

    public function exportExcel($id)
    {
        $header = $this->model->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Suhu_CF_' . date('Ymd_His') . '.csv');
        $o = fopen('php://output', 'w');
        fprintf($o, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($o, ['SUHU CHILLER & FREEZER']);
        fputcsv($o, ['Tanggal', $header['tanggal']]);
        fputcsv($o, []);
        fputcsv($o, ['', 'Pagi', 'Siang', 'Malam']);
        fputcsv($o, ['Chiller', $header['chiller_pagi'], $header['chiller_siang'], $header['chiller_malam']]);
        fputcsv($o, ['Freezer', $header['freezer_pagi'], $header['freezer_siang'], $header['freezer_malam']]);
        fputcsv($o, []);
        fputcsv($o, ['Kebersihan Rak', $header['kebersihan_rak']]);
        fclose($o);
        exit;
    }

    public function edit($id)
    {
        $header = $this->model->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('suhu_chiller_freezer/edit', ['header' => $header, 'title' => 'Edit Suhu Chiller & Freezer']);
    }

    public function update($id)
    {
        $this->model->update($id, [
            'tanggal'        => $this->request->getPost('tanggal'),
            'chiller_pagi'   => $this->request->getPost('chiller_pagi'),
            'chiller_siang'  => $this->request->getPost('chiller_siang'),
            'chiller_malam'  => $this->request->getPost('chiller_malam'),
            'freezer_pagi'   => $this->request->getPost('freezer_pagi'),
            'freezer_siang'  => $this->request->getPost('freezer_siang'),
            'freezer_malam'  => $this->request->getPost('freezer_malam'),
            'kebersihan_rak' => $this->request->getPost('kebersihan_rak'),
            'verifikasi'     => $this->request->getPost('verifikasi'),
            'nama_petugas'   => $this->request->getPost('nama_petugas'),
        ]);
        return redirect()->to('/suhu-chiller-freezer')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }
        $this->model->delete($id);
        return redirect()->to('/suhu-chiller-freezer')->with('success', 'Data berhasil dihapus.');
    }
}
