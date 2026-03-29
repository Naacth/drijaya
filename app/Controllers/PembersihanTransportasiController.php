<?php

namespace App\Controllers;

use App\Models\PembersihanTransportasiModel;
use App\Models\UserSignatureModel;

class PembersihanTransportasiController extends BaseController
{
    protected $model;
    public function __construct() { $this->model = new PembersihanTransportasiModel(); }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pembersihan_transportasi');
        $builder->select('pembersihan_transportasi.*, users.nama as user_nama');
        $builder->join('users', 'users.id = pembersihan_transportasi.created_by');
        $role = session()->get('role');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $builder->where('pembersihan_transportasi.created_by', session()->get('user_id'));
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $builder->where('users.sppg_id', $sppgId);
        }
        $builder->orderBy('pembersihan_transportasi.created_at', 'DESC');
        return view('pembersihan_transportasi/index', ['title' => 'Pembersihan Alat Transportasi', 'forms' => $builder->get()->getResultArray()]);
    }

    public function create() { return view('pembersihan_transportasi/create', ['title' => 'Buat Laporan Pembersihan Transportasi']); }

    public function store()
    {
        $data = [
            'bulan' => $this->request->getPost('bulan'),
            'tahun' => $this->request->getPost('tahun'),
            'nama_kendaraan' => $this->request->getPost('nama_kendaraan'),
            'rekap_data' => json_encode($this->request->getPost('rekap')),
            'nama_gizi' => $this->request->getPost('nama_gizi') ?: '-',
            'nama_kappg' => $this->request->getPost('nama_kappg') ?: 'Ka.SPPG',
            'created_by' => session()->get('user_id'),
        ];
        $this->model->insert($data);
        return redirect()->to('/pembersihan-transportasi')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('pembersihan_transportasi/show', ['title' => 'Detail Pembersihan Transportasi', 'header' => $form, 'rekap' => json_decode($form['rekap_data'], true)]);
    }

    public function edit($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('pembersihan_transportasi/edit', ['title' => 'Edit Pembersihan Transportasi', 'header' => $form, 'rekap' => json_decode($form['rekap_data'], true)]);
    }

    public function update($id)
    {
        $data = [
            'bulan' => $this->request->getPost('bulan'),
            'tahun' => $this->request->getPost('tahun'),
            'nama_kendaraan' => $this->request->getPost('nama_kendaraan'),
            'rekap_data' => json_encode($this->request->getPost('rekap')),
            'nama_gizi' => $this->request->getPost('nama_gizi') ?: '-',
            'nama_kappg' => $this->request->getPost('nama_kappg') ?: 'Ka.SPPG',
        ];
        $this->model->update($id, $data);
        return redirect()->to('/pembersihan-transportasi')->with('success', 'Data berhasil diperbarui.');
    }

    public function exportPdf($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('pembersihan_transportasi/print', [
            'header' => $form, 'rekap' => json_decode($form['rekap_data'], true), 'title' => 'Cetak Pembersihan Transportasi',
            'signature' => (new UserSignatureModel())->where('user_id', $form['created_by'])->first()
        ]);
    }

    public function exportExcel($id)
    {
        $form = $this->model->find($id);
        $rekap = json_decode($form['rekap_data'], true);
        header('Content-Type: text/csv'); header('Content-Disposition: attachment; filename=Transportasi.csv');
        $o = fopen('php://output', 'w'); fputcsv($o, ['PEMBERSIHAN ALAT TRANSPORTASI', $form['nama_kendaraan']]);
        fputcsv($o, ['Bulan', $form['bulan']]); fputcsv($o, ['Tahun', $form['tahun']]); fputcsv($o, []);
        fputcsv($o, ['No', 'Tanggal', 'Nama Personil', 'Jam', 'Keterangan']);
        foreach ($rekap as $i => $r) fputcsv($o, [$i+1, $r['tanggal'], $r['nama_personil'], $r['jam'], $r['keterangan']]);
        fclose($o); exit;
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }
        $this->model->delete($id);
        return redirect()->to('/pembersihan-transportasi')->with('success', 'Data berhasil dihapus.');
    }
}
