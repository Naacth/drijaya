<?php

namespace App\Controllers;

use App\Traits\ChecksAhliGiziOwnership;
use App\Models\PembersihanHarianModel;

class PembersihanHarianController extends BaseController
{
    use ChecksAhliGiziOwnership;

    protected $model;
    public function __construct() { $this->model = new PembersihanHarianModel(); }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pembersihan_harian');
        $builder->select('pembersihan_harian.*, users.nama as user_nama');
        $builder->join('users', 'users.id = pembersihan_harian.created_by');
        $role = session()->get('role');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $builder->where('pembersihan_harian.created_by', session()->get('user_id'));
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $builder->where('users.sppg_id', $sppgId);
        }
        $builder->orderBy('pembersihan_harian.created_at', 'DESC');
        return view('pembersihan_harian/index', ['title' => 'Pembersihan Freezer & Chiller (Harian)', 'forms' => $builder->get()->getResultArray()]);
    }

    public function create() { return view('pembersihan_harian/create', ['title' => 'Buat Form Pembersihan Harian']); }

    public function store()
    {
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'unit_type' => $this->request->getPost('unit_type'),
            'area_data' => json_encode($this->request->getPost('area')),
            'nama_petugas' => $this->request->getPost('nama_petugas'),
            'nama_verifikator' => $this->request->getPost('nama_verifikator'),
            'created_by' => session()->get('user_id'),
        ];
        $this->model->insert($data);
        return redirect()->to('/pembersihan-harian')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/pembersihan-harian')) {
            return $r;
        }
        return view('pembersihan_harian/show', ['title' => 'Detail Pembersihan Harian', 'header' => $form, 'area' => json_decode($form['area_data'], true)]);
    }

    public function exportPdf($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        
        $data = [
            'header' => $form, 
            'area' => json_decode($form['area_data'], true), 
            'title' => 'Cetak Pembersihan Harian',
            'signature' => signature_row_for_pdf(isset($form['created_by']) ? (int) $form['created_by'] : null)
        ];
        
        // This view should have window.print() triggered via JS for now as simple download proxy
        return view('pembersihan_harian/print', $data);
    }

    public function exportExcel($id)
    {
        $form = $this->model->find($id);
        $area = json_decode($form['area_data'], true);
        
        header('Content-Type: text/csv'); 
        header('Content-Disposition: attachment; filename=Pembersihan_Harian_'.date('Ymd').'.csv');
        $o = fopen('php://output', 'w'); 
        fputcsv($o, ['LAPORAN PEMBERSIHAN HARIAN']);
        fputcsv($o, ['Unit', strtoupper($form['unit_type'])]);
        fputcsv($o, ['Tanggal', $form['tanggal']]); 
        fputcsv($o, ['Petugas', $form['nama_petugas']]);
        fputcsv($o, []);
        fputcsv($o, ['Komponen', 'Status Kebersihan']); 
        foreach ($area as $k => $v) fputcsv($o, [ucfirst(str_replace('_', ' ', $k)), $v == '1' ? 'Bersih' : 'Kotor']);
        fclose($o); 
        exit;
    }

    public function edit($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/pembersihan-harian')) {
            return $r;
        }
        return view('pembersihan_harian/edit', [
            'title' => 'Edit Pembersihan Harian', 
            'header' => $form, 
            'area' => json_decode($form['area_data'], true)
        ]);
    }

    public function update($id)
    {
        $form = $this->model->find($id);
        if (!$form) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/pembersihan-harian')) {
            return $r;
        }

        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'unit_type' => $this->request->getPost('unit_type'),
            'area_data' => json_encode($this->request->getPost('area')),
            'nama_petugas' => $this->request->getPost('nama_petugas'),
            'nama_verifikator' => $this->request->getPost('nama_verifikator'),
        ];
        $this->model->update($id, $data);
        return redirect()->to('/pembersihan-harian')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }
        $this->model->delete($id);
        return redirect()->to('/pembersihan-harian')->with('success', 'Data berhasil dihapus.');
    }
}
