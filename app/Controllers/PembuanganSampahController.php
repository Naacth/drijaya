<?php

namespace App\Controllers;

use App\Traits\ChecksAhliGiziOwnership;
use App\Models\PembuanganSampahModel;

class PembuanganSampahController extends BaseController
{
    use ChecksAhliGiziOwnership;

    protected $model;
    public function __construct() { $this->model = new PembuanganSampahModel(); }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pembuangan_sampah');
        $builder->select('pembuangan_sampah.*, users.nama as user_nama');
        $builder->join('users', 'users.id = pembuangan_sampah.created_by');
        $role = session()->get('role');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $builder->where('pembuangan_sampah.created_by', session()->get('user_id'));
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $builder->where('users.sppg_id', $sppgId);
        }
        $builder->orderBy('pembuangan_sampah.created_at', 'DESC');
        return view('pembuangan_sampah/index', ['title' => 'Pembuangan Sampah Harian', 'forms' => $builder->get()->getResultArray()]);
    }

    public function create() { return view('pembuangan_sampah/create', ['title' => 'Buat Form Pembuangan Sampah']); }

    public function store()
    {
        $data = [
            'bulan' => $this->request->getPost('bulan'),
            'tahun' => $this->request->getPost('tahun'),
            'rekap_data' => json_encode($this->request->getPost('rekap')),
            'nama_kappg' => $this->request->getPost('nama_kappg'),
            'created_by' => session()->get('user_id'),
        ];
        $this->model->insert($data);
        return redirect()->to('/pembuangan-sampah')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/pembuangan-sampah')) {
            return $r;
        }
        return view('pembuangan_sampah/show', ['title' => 'Detail Pembuangan Sampah', 'header' => $form, 'rekap' => json_decode($form['rekap_data'], true)]);
    }

    public function exportExcel($id)
    {
        $form = $this->model->find($id);
        $rekap = json_decode($form['rekap_data'], true);
        header('Content-Type: text/csv'); header('Content-Disposition: attachment; filename=Sampah.csv');
        $o = fopen('php://output', 'w'); fputcsv($o, ['KONTROL PEMBUANGAN SAMPAH', $form['bulan'].' '.$form['tahun']]);
        $h = ['Waktu']; for($i=1;$i<=31;$i++) $h[] = $i; fputcsv($o, $h);
        foreach(['07.00', '14.00', '22.00'] as $t) {
            $r = [$t]; for($i=1;$i<=31;$i++) $r[] = (isset($rekap[$t][$i]) && $rekap[$t][$i] == '1') ? 'V' : '-';
            fputcsv($o, $r);
        }
        fclose($o); exit;
    }

    public function edit($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/pembuangan-sampah')) {
            return $r;
        }
        return view('pembuangan_sampah/edit', [
            'title' => 'Edit Pembuangan Sampah', 
            'header' => $form, 
            'rekap' => json_decode($form['rekap_data'], true)
        ]);
    }

    public function update($id)
    {
        $form = $this->model->find($id);
        if (!$form) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/pembuangan-sampah')) {
            return $r;
        }

        $data = [
            'bulan' => $this->request->getPost('bulan'),
            'tahun' => $this->request->getPost('tahun'),
            'rekap_data' => json_encode($this->request->getPost('rekap')),
            'nama_kappg' => $this->request->getPost('nama_kappg'),
        ];
        $this->model->update($id, $data);
        return redirect()->to('/pembuangan-sampah')->with('success', 'Data berhasil diperbarui.');
    }

    public function exportPdfBlank()
    {
        return view('pembuangan_sampah/print_blank', [
            'title' => 'Form Kontrol Pembuangan Sampah (kosong)',
        ]);
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }
        $this->model->delete($id);
        return redirect()->to('/pembuangan-sampah')->with('success', 'Data berhasil dihapus.');
    }
}
