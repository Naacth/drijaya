<?php

namespace App\Controllers;

use App\Models\AnalisisGiziModel;
use App\Models\AnalisisGiziItemModel;

class AnalisisGiziController extends BaseController
{
    protected $headerModel;
    protected $itemModel;

    public function __construct()
    {
        $this->headerModel = new AnalisisGiziModel();
        $this->itemModel   = new AnalisisGiziItemModel();
    }

    public function index()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('analisis_gizi');
        $builder->select('analisis_gizi.*, users.nama as user_nama');
        $builder->join('users', 'users.id = analisis_gizi.created_by');

        $role   = session()->get('role');
        $userId = session()->get('user_id');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $builder->where('analisis_gizi.created_by', $userId);
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $builder->where('users.sppg_id', $sppgId);
        }

        $builder->orderBy('analisis_gizi.created_at', 'DESC');
        $data['title'] = 'Analisis Kandungan Gizi (AKG)';
        $data['forms'] = $builder->get()->getResultArray();
        return view('analisis_gizi/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Buat Analisis Gizi';
        return view('analisis_gizi/create', $data);
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
            'nama_paket'     => $this->request->getPost('nama_paket'),
            'tanggal_sajian' => $this->request->getPost('tanggal_sajian'),
            'sppg_id'        => session()->get('sppg_id'),
            'created_by'     => session()->get('user_id'),
        ]);

        foreach ($items as $item) {
            $this->itemModel->insert([
                'analisis_gizi_id' => $headerId,
                'nama_item'        => $item['nama_item'],
                'gramasi'          => $item['gramasi'] ?? 0,
                'kalori'           => $item['kalori'] ?? 0,
                'protein'          => $item['protein'] ?? 0,
                'lemak'            => $item['lemak'] ?? 0,
                'karbohidrat'      => $item['karbohidrat'] ?? 0,
                'serat'            => $item['serat'] ?? 0,
            ]);
        }

        $db->transComplete();
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan data.')->withInput();
        }
        return redirect()->to('/analisis-gizi')->with('success', 'Data Analisis Gizi berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('analisis_gizi');
        $builder->select('analisis_gizi.*, users.nama as user_nama');
        $builder->join('users', 'users.id = analisis_gizi.created_by');
        $builder->where('analisis_gizi.id', $id);
        $header = $builder->get()->getRowArray();
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data['header'] = $header;
        $data['items']  = $this->itemModel->where('analisis_gizi_id', $id)->findAll();
        $data['title']  = 'Detail Analisis Gizi';
        return view('analisis_gizi/show', $data);
    }

    public function edit($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        
        $data = [
            'header' => $header,
            'items'  => $this->itemModel->where('analisis_gizi_id', $id)->findAll(),
            'title'  => 'Edit Analisis Gizi'
        ];
        return view('analisis_gizi/edit', $data);
    }

    public function update($id)
    {
        $items = $this->request->getPost('items');
        if (empty($items)) {
            return redirect()->back()->with('error', 'Minimal harus mengisi 1 baris.')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->headerModel->update($id, [
            'nama_paket'     => $this->request->getPost('nama_paket'),
            'tanggal_sajian' => $this->request->getPost('tanggal_sajian'),
        ]);

        $this->itemModel->where('analisis_gizi_id', $id)->delete();
        foreach ($items as $item) {
            $this->itemModel->insert([
                'analisis_gizi_id' => $id,
                'nama_item'        => $item['nama_item'],
                'gramasi'          => $item['gramasi'] ?? 0,
                'kalori'           => $item['kalori'] ?? 0,
                'protein'          => $item['protein'] ?? 0,
                'lemak'            => $item['lemak'] ?? 0,
                'karbohidrat'      => $item['karbohidrat'] ?? 0,
                'serat'            => $item['serat'] ?? 0,
            ]);
        }

        $db->transComplete();
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memperbarui data.')->withInput();
        }
        return redirect()->to('/analisis-gizi')->with('success', 'Data Analisis Gizi berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }

        $db = \Config\Database::connect();
        $db->transStart();
        
        $this->itemModel->where('analisis_gizi_id', $id)->delete();
        $this->headerModel->delete($id);

        $db->transComplete();
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menghapus data.');
        }

        return redirect()->to('/analisis-gizi')->with('success', 'Data Analisis Gizi berhasil dihapus.');
    }

    public function exportPdf($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('analisis_gizi');
        $builder->select('analisis_gizi.*, users.nama as user_nama, users.id as user_id');
        $builder->join('users', 'users.id = analisis_gizi.created_by');
        $builder->where('analisis_gizi.id', $id);
        $header = $builder->get()->getRowArray();

        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data['header']    = $header;
        $data['items']     = $this->itemModel->where('analisis_gizi_id', $id)->findAll();
        $data['title']     = 'Cetak Analisis Gizi';
        return view('analisis_gizi/print', $data);
    }

    public function exportExcel($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $items = $this->itemModel->where('analisis_gizi_id', $id)->findAll();

        $filename = 'AKG_' . date('Ymd') . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ANALISIS KANDUNGAN GIZI (AKG)']);
        fputcsv($output, ['Paket Menu', $header['nama_paket']]);
        fputcsv($output, ['Tanggal', $header['tanggal_sajian']]);
        fputcsv($output, []);
        fputcsv($output, ['No', 'Nama Item', 'Gramasi', 'Kalori', 'Protein', 'Lemak', 'KH', 'Serat']);
        foreach ($items as $i => $item) {
            fputcsv($output, [$i + 1, $item['nama_item'], $item['gramasi'], $item['kalori'], $item['protein'], $item['lemak'], $item['karbohidrat'], $item['serat']]);
        }
        fclose($output);
        exit;
    }
}
