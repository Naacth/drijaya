<?php

namespace App\Controllers;

use App\Models\StokGudangModel;
use App\Models\StokGudangItemModel;

class StokGudangController extends BaseController
{
    protected $headerModel;
    protected $itemModel;

    public function __construct()
    {
        $this->headerModel = new StokGudangModel();
        $this->itemModel   = new StokGudangItemModel();
    }

    public function index()
    {
        $role   = session()->get('role');
        $userId = session()->get('user_id');

        $db      = \Config\Database::connect();
        $builder = $db->table('stok_gudang');
        $builder->select('stok_gudang.*, users.nama as user_nama');
        $builder->join('users', 'users.id = stok_gudang.created_by');

        if ($role == 'aslap') {
            $builder->where('stok_gudang.created_by', $userId);
        } elseif ($role == 'admin' || $role == 'pic') {
            $currentSppgId = session()->get('sppg_id');
            if ($currentSppgId) {
                $builder->where('users.sppg_id', $currentSppgId);
            }
        }

        $builder->orderBy('stok_gudang.created_at', 'DESC');

        $data['title'] = 'Stok Barang di Gudang';
        $data['forms'] = $builder->get()->getResultArray();

        return view('stok_gudang/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Input Stok Barang Gudang';
        return view('stok_gudang/create', $data);
    }

    public function store()
    {
        $items = $this->request->getPost('items');
        if (empty($items)) {
            return redirect()->back()->with('error', 'Minimal harus mengisi 1 baris produk.')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $headerId = $this->headerModel->insert([
            'nama_sppg'  => $this->request->getPost('nama_sppg'),
            'tanggal'    => $this->request->getPost('tanggal'),
            'created_by' => session()->get('user_id'),
        ]);

        foreach ($items as $item) {
            $this->itemModel->insert([
                'stok_gudang_id' => $headerId,
                'nama_produk'    => $item['nama_produk'],
                'nama_penerima'  => $item['nama_penerima'] ?? '',
                'stok_awal'      => $item['stok_awal'] ?? '',
                'barang_masuk'   => $item['barang_masuk'] ?? '',
                'barang_keluar'  => $item['barang_keluar'] ?? '',
                'stok_akhir'     => $item['stok_akhir'] ?? '',
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan.')->withInput();
        }

        return redirect()->to('/stok-gudang')->with('success', 'Stok barang gudang berhasil disimpan.');
    }

    public function show($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('stok_gudang');
        $builder->select('stok_gudang.*, users.nama as user_nama');
        $builder->join('users', 'users.id = stok_gudang.created_by');
        $builder->where('stok_gudang.id', $id);
        $header = $builder->get()->getRowArray();

        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data['header'] = $header;
        $data['items']  = $this->itemModel->where('stok_gudang_id', $id)->findAll();
        $data['title']  = 'Detail Stok Gudang';

        return view('stok_gudang/show', $data);
    }

    public function exportPdf($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data['header'] = $header;
        $data['items']  = $this->itemModel->where('stok_gudang_id', $id)->findAll();
        $data['title']  = 'Cetak Stok Gudang';
        $data['signature'] = (new \App\Models\UserSignatureModel())->where('user_id', $header['created_by'])->first();

        return view('stok_gudang/print', $data);
    }

    public function exportExcel($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $items = $this->itemModel->where('stok_gudang_id', $id)->findAll();

        $filename = 'Stok_Gudang_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($output, ['STOCK BARANG DI GUDANG']);
        fputcsv($output, ['SPPG', $header['nama_sppg']]);
        fputcsv($output, ['Tanggal', $header['tanggal']]);
        fputcsv($output, []);
        fputcsv($output, ['No', 'Nama Produk', 'Nama Penerima', 'Stok Awal', 'Barang Masuk', 'Barang Keluar', 'Stok Akhir']);

        foreach ($items as $i => $item) {
            fputcsv($output, [
                $i + 1, $item['nama_produk'], $item['nama_penerima'],
                $item['stok_awal'], $item['barang_masuk'], $item['barang_keluar'], $item['stok_akhir'],
            ]);
        }

        fclose($output);
        exit;
    }
    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }

        $db = \Config\Database::connect();
        $db->transStart();
        $this->itemModel->where('stok_gudang_id', $id)->delete();
        $this->headerModel->delete($id);
        $db->transComplete();

        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal menghapus data.');
        return redirect()->to('/stok-gudang')->with('success', 'Data berhasil dihapus.');
    }
}
