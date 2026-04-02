<?php

namespace App\Controllers;

use App\Traits\ChecksAhliGiziOwnership;
use App\Models\SanitasiRuanganModel;

class SanitasiRuanganController extends BaseController
{
    use ChecksAhliGiziOwnership;

    protected $model;

    public function __construct() { $this->model = new SanitasiRuanganModel(); }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sanitasi_ruangan');
        $builder->select('sanitasi_ruangan.*, users.nama as user_nama');
        $builder->join('users', 'users.id = sanitasi_ruangan.created_by');
        
        $role = session()->get('role');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $builder->where('sanitasi_ruangan.created_by', session()->get('user_id'));
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $builder->where('users.sppg_id', $sppgId);
        }
        
        $builder->orderBy('sanitasi_ruangan.created_at', 'DESC');
        return view('sanitasi_ruangan/index', ['title' => 'Sanitasi Ruangan & Peralatan', 'forms' => $builder->get()->getResultArray()]);
    }

    public function create() { return view('sanitasi_ruangan/create', ['title' => 'Buat Form Sanitasi']); }

    public function store()
    {
        $fasilitas = $this->request->getPost('fasilitas');
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'fasilitas_data' => json_encode($fasilitas),
            'nama_pelaksana' => $this->request->getPost('nama_pelaksana'),
            'nama_pemeriksa' => $this->request->getPost('nama_pemeriksa'),
            'created_by' => session()->get('user_id'),
        ];
        if ($this->model->insert($data)) {
            return redirect()->to('/sanitasi-ruangan')->with('success', 'Data berhasil disimpan.');
        }
        return redirect()->back()->with('error', 'Gagal menyimpan data.')->withInput();
    }

    public function show($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/sanitasi-ruangan')) {
            return $r;
        }
        return view('sanitasi_ruangan/show', ['title' => 'Detail Sanitasi', 'header' => $form, 'fasilitas' => json_decode($form['fasilitas_data'], true)]);
    }

    public function exportPdf($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $data = [
            'header' => $form,
            'fasilitas' => json_decode($form['fasilitas_data'], true),
            'title' => 'Cetak Sanitasi',
            'signature' => signature_row_for_pdf(isset($form['created_by']) ? (int) $form['created_by'] : null)
        ];
        return view('sanitasi_ruangan/print', $data);
    }

    public function exportExcel($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $fasilitas = json_decode($form['fasilitas_data'], true);
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Sanitasi_' . $form['tanggal'] . '.csv');
        $o = fopen('php://output', 'w'); fprintf($o, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($o, ['SANITASI RUANGAN & PERALATAN']); fputcsv($o, ['Tanggal', $form['tanggal']]); fputcsv($o, []);
        fputcsv($o, ['Fasilitas', 'Status']);
        foreach ($fasilitas as $k => $v) { fputcsv($o, [ucfirst($k), $v == '1' ? 'Bersih' : 'Kotor']); }
        fclose($o); exit;
    }

    public function edit($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/sanitasi-ruangan')) {
            return $r;
        }
        return view('sanitasi_ruangan/edit', [
            'title' => 'Edit Sanitasi', 
            'header' => $form, 
            'fasilitas' => json_decode($form['fasilitas_data'], true)
        ]);
    }

    public function update($id)
    {
        $form = $this->model->find($id);
        if (!$form) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/sanitasi-ruangan')) {
            return $r;
        }

        $fasilitas = $this->request->getPost('fasilitas');
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'fasilitas_data' => json_encode($fasilitas),
            'nama_pelaksana' => $this->request->getPost('nama_pelaksana'),
            'nama_pemeriksa' => $this->request->getPost('nama_pemeriksa'),
        ];
        if ($this->model->update($id, $data)) {
            return redirect()->to('/sanitasi-ruangan')->with('success', 'Data berhasil diperbarui.');
        }
        return redirect()->back()->with('error', 'Gagal memperbarui data.')->withInput();
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }
        $this->model->delete($id);
        return redirect()->to('/sanitasi-ruangan')->with('success', 'Data berhasil dihapus.');
    }
}
