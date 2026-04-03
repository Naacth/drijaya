<?php

namespace App\Controllers;

use App\Traits\ChecksAhliGiziOwnership;
use App\Models\HigienePersonilModel;
class HigienePersonilController extends BaseController
{
    use ChecksAhliGiziOwnership;

    protected $model;
    public function __construct() { $this->model = new HigienePersonilModel(); }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('higiene_personil');
        $builder->select('higiene_personil.*, users.nama as user_nama');
        $builder->join('users', 'users.id = higiene_personil.created_by');
        $role = session()->get('role');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $builder->where('higiene_personil.created_by', session()->get('user_id'));
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $builder->where('users.sppg_id', $sppgId);
        }
        $builder->orderBy('higiene_personil.created_at', 'DESC');
        return view('higiene_personil/index', ['title' => 'Pemeriksaan Higiene Personil', 'forms' => $builder->get()->getResultArray()]);
    }

    public function create() { return view('higiene_personil/create', ['title' => 'Buat Laporan Higiene Personil']); }

    public function store()
    {
        $data = [
            'bulan' => $this->request->getPost('bulan'),
            'tahun' => $this->request->getPost('tahun'),
            'rekap_data' => json_encode($this->request->getPost('rekap')),
            'nama_gizi' => $this->request->getPost('nama_gizi') ?: '-',
            'nama_kappg' => $this->request->getPost('nama_kappg') ?: 'Ka.SPPG',
            'created_by' => session()->get('user_id'),
        ];
        $this->model->insert($data);
        return redirect()->to('/higiene-personil')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/higiene-personil')) {
            return $r;
        }
        return view('higiene_personil/show', ['title' => 'Detail Higiene Personil', 'header' => $form, 'rekap' => json_decode($form['rekap_data'], true)]);
    }

    public function edit($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/higiene-personil')) {
            return $r;
        }
        return view('higiene_personil/edit', ['title' => 'Edit Higiene Personil', 'header' => $form, 'rekap' => json_decode($form['rekap_data'], true)]);
    }

    public function update($id)
    {
        $form = $this->model->find($id);
        if (!$form) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($form, '/higiene-personil')) {
            return $r;
        }

        $data = [
            'bulan' => $this->request->getPost('bulan'),
            'tahun' => $this->request->getPost('tahun'),
            'rekap_data' => json_encode($this->request->getPost('rekap')),
            'nama_gizi' => $this->request->getPost('nama_gizi') ?: '-',
            'nama_kappg' => $this->request->getPost('nama_kappg') ?: 'Ka.SPPG',
        ];
        $this->model->update($id, $data);
        return redirect()->to('/higiene-personil')->with('success', 'Data berhasil diperbarui.');
    }

    public function exportPdf($id)
    {
        $form = $this->model->find($id);
        if (!$form) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('higiene_personil/print', [
            'header' => $form, 'rekap' => json_decode($form['rekap_data'], true), 'title' => 'Cetak Higiene Personil',
            'signature' => signature_row_for_pdf(isset($form['created_by']) ? (int) $form['created_by'] : null)
        ]);
    }

    public function exportPdfBlank()
    {
        helper('print');
        $rekap = [];
        for ($i = 0; $i < 15; $i++) {
            $rekap[] = [
                'tanggal'        => '',
                'nama_personil'  => '',
                'kuku'           => '',
                'rambut'         => '',
                'pakaian'        => '',
                'apd'            => '',
                'paraf'          => '',
                'keterangan'     => '',
            ];
        }

        return view('higiene_personil/print', [
            'blank'     => true,
            'header'    => [
                'bulan'      => '',
                'tahun'      => '',
                'nama_gizi'  => '',
                'nama_kappg' => '',
                'created_by' => null,
            ],
            'rekap'     => $rekap,
            'title'     => 'Form Higiene Personil (kosong)',
            'signature' => signature_row_for_pdf(null),
        ]);
    }

    public function exportExcel($id)
    {
        $form = $this->model->find($id);
        $rekap = json_decode($form['rekap_data'], true);
        header('Content-Type: text/csv'); header('Content-Disposition: attachment; filename=Higiene.csv');
        $o = fopen('php://output', 'w'); fputcsv($o, ['PEMERIKSAAN HIGIENE PERSONIL']);
        fputcsv($o, ['Bulan', $form['bulan']]); fputcsv($o, ['Tahun', $form['tahun']]); fputcsv($o, []);
        fputcsv($o, ['No', 'Tanggal', 'Nama Personil', 'Kuku', 'Rambut', 'Pakaian', 'APD', 'Keterangan']);
        foreach ($rekap as $i => $r) fputcsv($o, [$i+1, $r['tanggal'], $r['nama_personil'], $r['kuku'], $r['rambut'], $r['pakaian'], $r['apd'], $r['keterangan']]);
        fclose($o); exit;
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }
        $this->model->delete($id);
        return redirect()->to('/higiene-personil')->with('success', 'Data berhasil dihapus.');
    }
}
