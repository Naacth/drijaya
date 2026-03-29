<?php

namespace App\Controllers;

use App\Models\PemeriksaanSampelModel;

class PemeriksaanSampelController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PemeriksaanSampelModel();
    }

    public function index()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('pemeriksaan_sampel');
        $builder->select('pemeriksaan_sampel.*, users.nama as user_nama');
        $builder->join('users', 'users.id = pemeriksaan_sampel.created_by');

        $role = session()->get('role');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $builder->where('pemeriksaan_sampel.created_by', session()->get('user_id'));
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $builder->where('users.sppg_id', $sppgId);
        }

        $builder->orderBy('pemeriksaan_sampel.created_at', 'DESC');
        $data['title'] = 'Pemeriksaan & Sampel Makanan';
        $data['forms'] = $builder->get()->getResultArray();
        return view('pemeriksaan_sampel/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Buat Form Pemeriksaan & Sampel';
        return view('pemeriksaan_sampel/create', $data);
    }

    public function store()
    {
        $this->model->insert([
            'tanggal'             => $this->request->getPost('tanggal'),
            'jam_matang'          => $this->request->getPost('jam_matang'),
            'jenis_produk'        => $this->request->getPost('jenis_produk'),
            'bahaya_fisik'        => $this->request->getPost('bahaya_fisik'),
            'bahaya_biologi'      => $this->request->getPost('bahaya_biologi'),
            'jam_penarikan'       => $this->request->getPost('jam_penarikan'),
            'tindak_lanjut'       => $this->request->getPost('tindak_lanjut'),
            'sampel_diambil'      => $this->request->getPost('sampel_diambil'),
            'jumlah_sampel'       => $this->request->getPost('jumlah_sampel'),
            'tempat_penyimpanan'  => $this->request->getPost('tempat_penyimpanan'),
            'tanggal_pemusnahan'  => $this->request->getPost('tanggal_pemusnahan') ?: null,
            'nama_pemeriksa'      => $this->request->getPost('nama_pemeriksa'),
            'created_by'          => session()->get('user_id'),
        ]);

        return redirect()->to('/pemeriksaan-sampel')->with('success', 'Data Pemeriksaan & Sampel berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pemeriksaan_sampel');
        $builder->select('pemeriksaan_sampel.*, users.nama as user_nama');
        $builder->join('users', 'users.id = pemeriksaan_sampel.created_by');
        $builder->where('pemeriksaan_sampel.id', $id);
        $header = $builder->get()->getRowArray();
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data['header'] = $header;
        $data['title']  = 'Detail Pemeriksaan & Sampel';
        return view('pemeriksaan_sampel/show', $data);
    }

    public function exportPdf($id)
    {
        $header = $this->model->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $data['header']    = $header;
        $data['title']     = 'Cetak Pemeriksaan & Sampel';
        $data['signature'] = (new \App\Models\UserSignatureModel())->where('user_id', $header['created_by'])->first();
        return view('pemeriksaan_sampel/print', $data);
    }

    public function exportExcel($id)
    {
        $header = $this->model->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $filename = 'Pemeriksaan_Sampel_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($output, ['PEMERIKSAAN & SAMPEL MAKANAN']);
        fputcsv($output, ['Tanggal', $header['tanggal']]);
        fputcsv($output, ['Jam Matang', $header['jam_matang']]);
        fputcsv($output, ['Jenis Produk', $header['jenis_produk']]);
        fputcsv($output, ['Bahaya Fisik', $header['bahaya_fisik']]);
        fputcsv($output, ['Bahaya Biologi', $header['bahaya_biologi']]);
        fputcsv($output, ['Jam Penarikan', $header['jam_penarikan']]);
        fputcsv($output, ['Tindak Lanjut', $header['tindak_lanjut']]);
        fputcsv($output, ['Sampel Diambil', $header['sampel_diambil']]);
        fputcsv($output, ['Jumlah Sampel', $header['jumlah_sampel']]);
        fputcsv($output, ['Tempat Penyimpanan', $header['tempat_penyimpanan']]);
        fputcsv($output, ['Tanggal Pemusnahan', $header['tanggal_pemusnahan']]);
        fputcsv($output, ['Nama Pemeriksa', $header['nama_pemeriksa']]);
        fclose($output);
        exit;
    }

    public function edit($id)
    {
        $header = $this->model->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        
        $data = [
            'header' => $header,
            'title'  => 'Edit Pemeriksaan & Sampel'
        ];
        return view('pemeriksaan_sampel/edit', $data);
    }

    public function update($id)
    {
        $this->model->update($id, [
            'tanggal'             => $this->request->getPost('tanggal'),
            'jam_matang'          => $this->request->getPost('jam_matang'),
            'jenis_produk'        => $this->request->getPost('jenis_produk'),
            'bahaya_fisik'        => $this->request->getPost('bahaya_fisik'),
            'bahaya_biologi'      => $this->request->getPost('bahaya_biologi'),
            'jam_penarikan'       => $this->request->getPost('jam_penarikan'),
            'tindak_lanjut'       => $this->request->getPost('tindak_lanjut'),
            'sampel_diambil'      => $this->request->getPost('sampel_diambil'),
            'jumlah_sampel'       => $this->request->getPost('jumlah_sampel'),
            'tempat_penyimpanan'  => $this->request->getPost('tempat_penyimpanan'),
            'tanggal_pemusnahan'  => $this->request->getPost('tanggal_pemusnahan') ?: null,
            'nama_pemeriksa'      => $this->request->getPost('nama_pemeriksa'),
        ]);

        return redirect()->to('/pemeriksaan-sampel')->with('success', 'Data Pemeriksaan & Sampel berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }
        $this->model->delete($id);
        return redirect()->to('/pemeriksaan-sampel')->with('success', 'Data berhasil dihapus.');
    }
}
