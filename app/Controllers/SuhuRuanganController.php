<?php

namespace App\Controllers;

use App\Models\SuhuRuanganModel;

class SuhuRuanganController extends BaseController
{
    protected $model;

    public function __construct() { $this->model = new SuhuRuanganModel(); }

    public function index()
    {
        $db = \Config\Database::connect(); $b = $db->table('catatan_suhu_ruangan');
        $b->select('catatan_suhu_ruangan.*, users.nama as user_nama')->join('users', 'users.id = catatan_suhu_ruangan.created_by');
        $role = session()->get('role');
        if ($role == 'ahli_gizi') $b->where('catatan_suhu_ruangan.created_by', session()->get('user_id'));
        elseif ($role == 'admin') { $s = session()->get('sppg_id'); if ($s) $b->where('users.sppg_id', $s); }
        $b->orderBy('catatan_suhu_ruangan.created_at', 'DESC');
        return view('suhu_ruangan/index', ['title' => 'Catatan Suhu Ruangan', 'forms' => $b->get()->getResultArray()]);
    }

    public function create() { return view('suhu_ruangan/create', ['title' => 'Input Catatan Suhu Ruangan']); }

    public function store()
    {
        $this->model->insert([
            'tanggal' => $this->request->getPost('tanggal'),
            'pagi_jam' => $this->request->getPost('pagi_jam'), 'pagi_kelembapan' => $this->request->getPost('pagi_kelembapan'),
            'pagi_suhu' => $this->request->getPost('pagi_suhu'), 'pagi_keterangan' => $this->request->getPost('pagi_keterangan'),
            'siang_jam' => $this->request->getPost('siang_jam'), 'siang_kelembapan' => $this->request->getPost('siang_kelembapan'),
            'siang_suhu' => $this->request->getPost('siang_suhu'), 'siang_keterangan' => $this->request->getPost('siang_keterangan'),
            'sore_jam' => $this->request->getPost('sore_jam'), 'sore_kelembapan' => $this->request->getPost('sore_kelembapan'),
            'sore_suhu' => $this->request->getPost('sore_suhu'), 'sore_keterangan' => $this->request->getPost('sore_keterangan'),
            'nama_petugas' => $this->request->getPost('nama_petugas'),
            'created_by' => session()->get('user_id'),
        ]);
        return redirect()->to('/suhu-ruangan')->with('success', 'Catatan suhu ruangan berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect(); $b = $db->table('catatan_suhu_ruangan');
        $b->select('catatan_suhu_ruangan.*, users.nama as user_nama')->join('users', 'users.id = catatan_suhu_ruangan.created_by')->where('catatan_suhu_ruangan.id', $id);
        $header = $b->get()->getRowArray();
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('suhu_ruangan/show', ['header' => $header, 'title' => 'Detail Suhu Ruangan']);
    }

    public function exportPdf($id)
    {
        $header = $this->model->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('suhu_ruangan/print', ['header' => $header, 'title' => 'Cetak Suhu Ruangan', 'signature' => (new \App\Models\UserSignatureModel())->where('user_id', $header['created_by'])->first()]);
    }

    public function exportExcel($id)
    {
        $header = $this->model->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Suhu_Ruangan_' . date('Ymd_His') . '.csv');
        $o = fopen('php://output', 'w'); fprintf($o, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($o, ['CATATAN SUHU RUANGAN']); fputcsv($o, ['Tanggal', $header['tanggal']]); fputcsv($o, []);
        fputcsv($o, ['Waktu','Jam','Kelembapan','Suhu','Keterangan']);
        fputcsv($o, ['Pagi',$header['pagi_jam'],$header['pagi_kelembapan'],$header['pagi_suhu'],$header['pagi_keterangan']]);
        fputcsv($o, ['Siang',$header['siang_jam'],$header['siang_kelembapan'],$header['siang_suhu'],$header['siang_keterangan']]);
        fputcsv($o, ['Sore',$header['sore_jam'],$header['sore_kelembapan'],$header['sore_suhu'],$header['sore_keterangan']]);
        fclose($o); exit;
    }

    public function edit($id)
    {
        $header = $this->model->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('suhu_ruangan/edit', ['header' => $header, 'title' => 'Edit Suhu Ruangan']);
    }

    public function update($id)
    {
        $this->model->update($id, [
            'tanggal'         => $this->request->getPost('tanggal'),
            'pagi_jam'        => $this->request->getPost('pagi_jam'), 
            'pagi_kelembapan' => $this->request->getPost('pagi_kelembapan'),
            'pagi_suhu'       => $this->request->getPost('pagi_suhu'), 
            'pagi_keterangan' => $this->request->getPost('pagi_keterangan'),
            'siang_jam'       => $this->request->getPost('siang_jam'), 
            'siang_kelembapan'=> $this->request->getPost('siang_kelembapan'),
            'siang_suhu'      => $this->request->getPost('siang_suhu'), 
            'siang_keterangan'=> $this->request->getPost('siang_keterangan'),
            'sore_jam'        => $this->request->getPost('sore_jam'), 
            'sore_kelembapan' => $this->request->getPost('sore_kelembapan'),
            'sore_suhu'       => $this->request->getPost('sore_suhu'), 
            'sore_keterangan' => $this->request->getPost('sore_keterangan'),
            'nama_petugas'    => $this->request->getPost('nama_petugas'),
        ]);
        return redirect()->to('/suhu-ruangan')->with('success', 'Data berhasil diperbarui.');
    }
}
