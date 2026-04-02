<?php

namespace App\Controllers;

use App\Traits\ChecksAhliGiziOwnership;
use App\Models\UjiCitaRasaModel;
use App\Models\UjiCitaRasaItemModel;

class UjiCitaRasaController extends BaseController
{
    use ChecksAhliGiziOwnership;

    protected $headerModel;
    protected $itemModel;

    public function __construct()
    {
        $this->headerModel = new UjiCitaRasaModel();
        $this->itemModel   = new UjiCitaRasaItemModel();
    }

    public function index()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('uji_cita_rasa');
        $builder->select('uji_cita_rasa.*, users.nama as user_nama');
        $builder->join('users', 'users.id = uji_cita_rasa.created_by');

        $role   = session()->get('role');
        $userId = session()->get('user_id');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $builder->where('uji_cita_rasa.created_by', $userId);
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $builder->where('users.sppg_id', $sppgId);
        }

        $builder->orderBy('uji_cita_rasa.created_at', 'DESC');
        $data['title'] = 'Uji Cita Rasa (Tester)';
        $data['forms'] = $builder->get()->getResultArray();
        return view('uji_cita_rasa/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Buat Form Uji Cita Rasa';
        return view('uji_cita_rasa/create', $data);
    }

    public function store()
    {
        $items = $this->request->getPost('items');
        if (empty($items)) {
            return redirect()->back()->with('error', 'Minimal harus mengisi 1 baris.')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $headerId = $this->headerModel->insert([
            'tanggal'         => $this->request->getPost('tanggal'),
            'nama_checker'    => $this->request->getPost('nama_checker'),
            'nama_chef'       => $this->request->getPost('nama_chef'),
            'nama_ahli_gizi'  => $this->request->getPost('nama_ahli_gizi'),
            'created_by'      => session()->get('user_id'),
        ]);

        foreach ($items as $item) {
            $this->itemModel->insert([
                'uji_cita_rasa_id' => $headerId,
                'nama_masakan'     => $item['nama_masakan'],
                'gramasi_standar'  => $item['gramasi_standar'] ?? '',
                'gramasi_real'     => $item['gramasi_real'] ?? '',
                'masalah'          => $item['masalah'] ?? '',
                'penyelesaian'     => $item['penyelesaian'] ?? '',
            ]);
        }

        $db->transComplete();
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan data.')->withInput();
        }
        return redirect()->to('/uji-cita-rasa')->with('success', 'Data Uji Cita Rasa berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('uji_cita_rasa');
        $builder->select('uji_cita_rasa.*, users.nama as user_nama');
        $builder->join('users', 'users.id = uji_cita_rasa.created_by');
        $builder->where('uji_cita_rasa.id', $id);
        $header = $builder->get()->getRowArray();
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($header, '/uji-cita-rasa')) {
            return $r;
        }

        $data['header'] = $header;
        $data['items']  = $this->itemModel->where('uji_cita_rasa_id', $id)->findAll();
        $data['title']  = 'Detail Uji Cita Rasa';
        return view('uji_cita_rasa/show', $data);
    }

    public function exportPdf($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $data['header']    = $header;
        $data['items']     = $this->itemModel->where('uji_cita_rasa_id', $id)->findAll();
        $data['title']     = 'Cetak Uji Cita Rasa';
        $data['signature'] = signature_row_for_pdf(isset($header['created_by']) ? (int) $header['created_by'] : null);
        return view('uji_cita_rasa/print', $data);
    }

    public function exportExcel($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $items = $this->itemModel->where('uji_cita_rasa_id', $id)->findAll();

        $filename = 'Uji_Cita_Rasa_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($output, ['UJI CITA RASA (TESTER)']);
        fputcsv($output, ['Tanggal', $header['tanggal']]);
        fputcsv($output, ['Checker', $header['nama_checker']]);
        fputcsv($output, []);
        fputcsv($output, ['No', 'Nama Masakan', 'Gramasi Standar', 'Gramasi Real', 'Masalah', 'Penyelesaian']);
        foreach ($items as $i => $item) {
            fputcsv($output, [$i + 1, $item['nama_masakan'], $item['gramasi_standar'], $item['gramasi_real'], $item['masalah'], $item['penyelesaian']]);
        }
        fclose($output);
        exit;
    }

    public function edit($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($header, '/uji-cita-rasa')) {
            return $r;
        }

        $data = [
            'header' => $header,
            'items'  => $this->itemModel->where('uji_cita_rasa_id', $id)->findAll(),
            'title'  => 'Edit Uji Cita Rasa'
        ];
        return view('uji_cita_rasa/edit', $data);
    }

    public function update($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($header, '/uji-cita-rasa')) {
            return $r;
        }

        $items = $this->request->getPost('items');
        if (empty($items)) {
            return redirect()->back()->with('error', 'Minimal harus mengisi 1 baris.')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->headerModel->update($id, [
            'tanggal'         => $this->request->getPost('tanggal'),
            'nama_checker'    => $this->request->getPost('nama_checker'),
            'nama_chef'       => $this->request->getPost('nama_chef'),
            'nama_ahli_gizi'  => $this->request->getPost('nama_ahli_gizi'),
        ]);

        $this->itemModel->where('uji_cita_rasa_id', $id)->delete();
        foreach ($items as $item) {
            $this->itemModel->insert([
                'uji_cita_rasa_id' => $id,
                'nama_masakan'     => $item['nama_masakan'],
                'gramasi_standar'  => $item['gramasi_standar'] ?? '',
                'gramasi_real'     => $item['gramasi_real'] ?? '',
                'masalah'          => $item['masalah'] ?? '',
                'penyelesaian'     => $item['penyelesaian'] ?? '',
            ]);
        }

        $db->transComplete();
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memperbarui data.')->withInput();
        }
        return redirect()->to('/uji-cita-rasa')->with('success', 'Data Uji Cita Rasa berhasil diperbarui.');
    }
    
    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }

        $db = \Config\Database::connect();
        $db->transStart();
        
        $this->itemModel->where('uji_cita_rasa_id', $id)->delete();
        $this->headerModel->delete($id);

        $db->transComplete();
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menghapus data.');
        }

        return redirect()->to('/uji-cita-rasa')->with('success', 'Data Uji Cita Rasa berhasil dihapus.');
    }
}
