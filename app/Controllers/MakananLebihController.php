<?php

namespace App\Controllers;

use App\Models\MakananLebihModel;
use App\Models\MakananLebihItemModel;

class MakananLebihController extends BaseController
{
    protected $headerModel;
    protected $itemModel;

    public function __construct()
    {
        $this->headerModel = new MakananLebihModel();
        $this->itemModel   = new MakananLebihItemModel();
    }

    public function index()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('makanan_lebih');
        $builder->select('makanan_lebih.*, users.nama as user_nama');
        $builder->join('users', 'users.id = makanan_lebih.created_by');

        $role = session()->get('role');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $builder->where('makanan_lebih.created_by', session()->get('user_id'));
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $builder->where('users.sppg_id', $sppgId);
        }
        $builder->orderBy('makanan_lebih.created_at', 'DESC');
        $data['title'] = 'Penanganan Makanan Lebih';
        $data['forms'] = $builder->get()->getResultArray();
        return view('makanan_lebih/index', $data);
    }

    public function create()
    {
        return view('makanan_lebih/create', ['title' => 'Buat Form Makanan Lebih']);
    }

    public function store()
    {
        $items = $this->request->getPost('items');
        if (empty($items)) return redirect()->back()->with('error', 'Minimal 1 baris item.')->withInput();

        $db = \Config\Database::connect();
        $db->transStart();
        $headerId = $this->headerModel->insert([
            'tanggal'         => $this->request->getPost('tanggal'),
            'nama_cook'       => $this->request->getPost('nama_cook'),
            'nama_chef'       => $this->request->getPost('nama_chef'),
            'nama_ahli_gizi'  => $this->request->getPost('nama_ahli_gizi'),
            'created_by'      => session()->get('user_id'),
        ]);
        foreach ($items as $item) {
            $this->itemModel->insert([
                'makanan_lebih_id' => $headerId,
                'nama_item'        => $item['nama_item'],
                'jumlah'           => $item['jumlah'] ?? '',
                'kondisi'          => $item['kondisi'] ?? '',
                'tindakan'         => $item['tindakan'] ?? '',
            ]);
        }
        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal menyimpan.')->withInput();
        return redirect()->to('/makanan-lebih')->with('success', 'Data Makanan Lebih berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('makanan_lebih');
        $builder->select('makanan_lebih.*, users.nama as user_nama');
        $builder->join('users', 'users.id = makanan_lebih.created_by');
        $builder->where('makanan_lebih.id', $id);
        $header = $builder->get()->getRowArray();
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $data['header'] = $header;
        $data['items']  = $this->itemModel->where('makanan_lebih_id', $id)->findAll();
        $data['title']  = 'Detail Makanan Lebih';
        return view('makanan_lebih/show', $data);
    }

    public function exportPdf($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $data['header']    = $header;
        $data['items']     = $this->itemModel->where('makanan_lebih_id', $id)->findAll();
        $data['title']     = 'Cetak Makanan Lebih';
        $data['signature'] = (new \App\Models\UserSignatureModel())->where('user_id', $header['created_by'])->first();
        return view('makanan_lebih/print', $data);
    }

    public function exportExcel($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $items = $this->itemModel->where('makanan_lebih_id', $id)->findAll();
        $filename = 'Makanan_Lebih_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($output, ['PENANGANAN MAKANAN LEBIH']);
        fputcsv($output, ['Tanggal', $header['tanggal']]);
        fputcsv($output, []);
        fputcsv($output, ['No', 'Nama Item', 'Jumlah', 'Kondisi', 'Tindakan']);
        foreach ($items as $i => $item) {
            fputcsv($output, [$i + 1, $item['nama_item'], $item['jumlah'], $item['kondisi'], $item['tindakan']]);
        }
        fclose($output);
        exit;
    }

    public function edit($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        
        $data = [
            'header' => $header,
            'items'  => $this->itemModel->where('makanan_lebih_id', $id)->findAll(),
            'title'  => 'Edit Penanganan Makanan Lebih'
        ];
        return view('makanan_lebih/edit', $data);
    }

    public function update($id)
    {
        $items = $this->request->getPost('items');
        if (empty($items)) return redirect()->back()->with('error', 'Minimal harus mengisi 1 baris.')->withInput();

        $db = \Config\Database::connect();
        $db->transStart();

        $this->headerModel->update($id, [
            'tanggal'         => $this->request->getPost('tanggal'),
            'nama_cook'       => $this->request->getPost('nama_cook'),
            'nama_chef'       => $this->request->getPost('nama_chef'),
            'nama_ahli_gizi'  => $this->request->getPost('nama_ahli_gizi'),
        ]);

        $this->itemModel->where('makanan_lebih_id', $id)->delete();
        foreach ($items as $item) {
            $this->itemModel->insert([
                'makanan_lebih_id' => $id,
                'nama_item'        => $item['nama_item'],
                'jumlah'           => $item['jumlah'] ?? '',
                'kondisi'          => $item['kondisi'] ?? '',
                'tindakan'         => $item['tindakan'] ?? '',
            ]);
        }

        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal memperbarui data.')->withInput();
        return redirect()->to('/makanan-lebih')->with('success', 'Data Makanan Lebih berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }

        $db = \Config\Database::connect();
        $db->transStart();
        $this->itemModel->where('makanan_lebih_id', $id)->delete();
        $this->headerModel->delete($id);
        $db->transComplete();

        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal menghapus.');
        return redirect()->to('/makanan-lebih')->with('success', 'Data berhasil dihapus.');
    }
}
