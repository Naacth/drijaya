<?php

namespace App\Controllers;

use App\Traits\ChecksAhliGiziOwnership;
use App\Models\PencucianBahanModel;
use App\Models\PencucianBahanItemModel;

class PencucianBahanController extends BaseController
{
    use ChecksAhliGiziOwnership;

    protected $headerModel;
    protected $itemModel;

    public function __construct()
    {
        $this->headerModel = new PencucianBahanModel();
        $this->itemModel   = new PencucianBahanItemModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $b = $db->table('pencucian_bahan');
        $b->select('pencucian_bahan.*, users.nama as user_nama');
        $b->join('users', 'users.id = pencucian_bahan.created_by');
        $role = session()->get('role');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $b->where('pencucian_bahan.created_by', session()->get('user_id'));
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $b->where('users.sppg_id', $sppgId);
        }
        $b->orderBy('pencucian_bahan.created_at', 'DESC');
        return view('pencucian_bahan/index', [
            'title' => 'Pencucian Bahan Makanan',
            'forms' => $b->get()->getResultArray()
        ]);
    }

    public function create()
    {
        return view('pencucian_bahan/create', ['title' => 'Buat Form Pencucian Bahan']);
    }

    public function store()
    {
        $items = $this->request->getPost('items');
        if (empty($items)) return redirect()->back()->with('error', 'Minimal 1 baris.')->withInput();
        $db = \Config\Database::connect();
        $db->transStart();
        $headerId = $this->headerModel->insert([
            'tanggal'      => $this->request->getPost('tanggal'),
            'nama_petugas' => $this->request->getPost('nama_petugas'),
            'created_by'   => session()->get('user_id'),
        ]);
        foreach ($items as $item) {
            $this->itemModel->insert([
                'pencucian_bahan_id' => $headerId,
                'nama_bahan'    => $item['nama_bahan'],
                'bahan_kimia'   => $item['bahan_kimia'] ?? '',
                'benda_asing'   => $item['benda_asing'] ?? '',
                'tindak_lanjut' => $item['tindak_lanjut'] ?? '',
                'jam_produksi'  => $item['jam_produksi'] ?? '',
            ]);
        }
        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal menyimpan.')->withInput();
        return redirect()->to('/pencucian-bahan')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect();
        $b = $db->table('pencucian_bahan');
        $b->select('pencucian_bahan.*, users.nama as user_nama');
        $b->join('users', 'users.id = pencucian_bahan.created_by');
        $b->where('pencucian_bahan.id', $id);
        $header = $b->get()->getRowArray();
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($header, '/pencucian-bahan')) {
            return $r;
        }
        return view('pencucian_bahan/show', [
            'header' => $header,
            'items'  => $this->itemModel->where('pencucian_bahan_id', $id)->findAll(),
            'title'  => 'Detail Pencucian Bahan'
        ]);
    }

    public function exportPdf($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $sig = signature_row_for_pdf(isset($header['created_by']) ? (int) $header['created_by'] : null);
        return view('pencucian_bahan/print', [
            'header'    => $header,
            'items'     => $this->itemModel->where('pencucian_bahan_id', $id)->findAll(),
            'title'     => 'Cetak Pencucian Bahan',
            'signature' => $sig
        ]);
    }

    public function exportExcel($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $items = $this->itemModel->where('pencucian_bahan_id', $id)->findAll();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Pencucian_Bahan_' . date('Ymd_His') . '.csv');
        $o = fopen('php://output', 'w');
        fprintf($o, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($o, ['PENCUCIAN BAHAN MAKANAN']);
        fputcsv($o, ['Tanggal', $header['tanggal']]);
        fputcsv($o, []);
        fputcsv($o, ['No', 'Nama Bahan', 'Bahan Kimia', 'Benda Asing', 'Tindak Lanjut', 'Jam Produksi']);
        foreach ($items as $i => $item) {
            fputcsv($o, [$i + 1, $item['nama_bahan'], $item['bahan_kimia'], $item['benda_asing'], $item['tindak_lanjut'], $item['jam_produksi']]);
        }
        fclose($o);
        exit;
    }

    public function edit($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($header, '/pencucian-bahan')) {
            return $r;
        }

        $data = [
            'header' => $header,
            'items'  => $this->itemModel->where('pencucian_bahan_id', $id)->findAll(),
            'title'  => 'Edit Pencucian Bahan'
        ];
        return view('pencucian_bahan/edit', $data);
    }

    public function update($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($header, '/pencucian-bahan')) {
            return $r;
        }

        $items = $this->request->getPost('items');
        if (empty($items)) return redirect()->back()->with('error', 'Minimal 1 baris.')->withInput();

        $db = \Config\Database::connect();
        $db->transStart();

        $this->headerModel->update($id, [
            'tanggal'      => $this->request->getPost('tanggal'),
            'nama_petugas' => $this->request->getPost('nama_petugas'),
        ]);

        $this->itemModel->where('pencucian_bahan_id', $id)->delete();
        foreach ($items as $item) {
            $this->itemModel->insert([
                'pencucian_bahan_id' => $id,
                'nama_bahan'    => $item['nama_bahan'],
                'bahan_kimia'   => $item['bahan_kimia'] ?? '',
                'benda_asing'   => $item['benda_asing'] ?? '',
                'tindak_lanjut' => $item['tindak_lanjut'] ?? '',
                'jam_produksi'  => $item['jam_produksi'] ?? '',
            ]);
        }

        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal memperbarui.')->withInput();
        return redirect()->to('/pencucian-bahan')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }

        $db = \Config\Database::connect();
        $db->transStart();
        $this->itemModel->where('pencucian_bahan_id', $id)->delete();
        $this->headerModel->delete($id);
        $db->transComplete();

        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal menghapus.');
        return redirect()->to('/pencucian-bahan')->with('success', 'Data berhasil dihapus.');
    }
}
