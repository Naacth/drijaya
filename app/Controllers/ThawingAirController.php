<?php

namespace App\Controllers;

use App\Traits\ChecksAhliGiziOwnership;
use App\Models\ThawingAirModel;
use App\Models\ThawingAirItemModel;

class ThawingAirController extends BaseController
{
    use ChecksAhliGiziOwnership;

    protected $headerModel;
    protected $itemModel;

    public function __construct()
    {
        $this->headerModel = new ThawingAirModel();
        $this->itemModel   = new ThawingAirItemModel();
    }

    public function index()
    {
        $db = \Config\Database::connect(); $b = $db->table('checklist_thawing_air');
        $b->select('checklist_thawing_air.*, users.nama as user_nama')->join('users', 'users.id = checklist_thawing_air.created_by');
        $role = session()->get('role');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $b->where('checklist_thawing_air.created_by', session()->get('user_id'));
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $b->where('users.sppg_id', $sppgId);
        }
        $b->orderBy('checklist_thawing_air.created_at', 'DESC');
        return view('thawing_air/index', ['title' => 'Checklist Thawing (Air)', 'forms' => $b->get()->getResultArray()]);
    }

    public function create() { return view('thawing_air/create', ['title' => 'Buat Checklist Thawing Air']); }

    public function store()
    {
        $items = $this->request->getPost('items');
        if (empty($items)) return redirect()->back()->with('error', 'Minimal 1 baris.')->withInput();
        $db = \Config\Database::connect(); $db->transStart();
        $headerId = $this->headerModel->insert([
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_petugas' => $this->request->getPost('nama_petugas'),
            'created_by' => session()->get('user_id'),
        ]);
        foreach ($items as $item) {
            $this->itemModel->insert([
                'checklist_thawing_air_id' => $headerId,
                'nama_bahan' => $item['nama_bahan'],
                'jumlah' => $item['jumlah'] ?? '',
                'suhu_air' => $item['suhu_air'] ?? '',
                'waktu_thawing' => $item['waktu_thawing'] ?? '',
                'paraf' => $item['paraf'] ?? '',
            ]);
        }
        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal menyimpan.')->withInput();
        return redirect()->to('/thawing-air')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect(); $b = $db->table('checklist_thawing_air');
        $b->select('checklist_thawing_air.*, users.nama as user_nama')->join('users', 'users.id = checklist_thawing_air.created_by')->where('checklist_thawing_air.id', $id);
        $header = $b->get()->getRowArray();
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($header, '/thawing-air')) {
            return $r;
        }
        return view('thawing_air/show', ['header' => $header, 'items' => $this->itemModel->where('checklist_thawing_air_id', $id)->findAll(), 'title' => 'Detail Thawing Air']);
    }

    public function exportPdf($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('thawing_air/print', ['header' => $header, 'items' => $this->itemModel->where('checklist_thawing_air_id', $id)->findAll(), 'title' => 'Cetak Thawing Air', 'signature' => signature_row_for_pdf(isset($header['created_by']) ? (int) $header['created_by'] : null)]);
    }

    public function exportExcel($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $items = $this->itemModel->where('checklist_thawing_air_id', $id)->findAll();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Thawing_Air_' . date('Ymd_His') . '.csv');
        $o = fopen('php://output', 'w'); fprintf($o, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($o, ['CHECKLIST THAWING (METODE AIR)']); fputcsv($o, ['Tanggal', $header['tanggal']]); fputcsv($o, []);
        fputcsv($o, ['No','Nama Bahan','Jumlah','Suhu Air','Waktu Thawing','Paraf']);
        foreach ($items as $i => $item) { fputcsv($o, [$i+1,$item['nama_bahan'],$item['jumlah'],$item['suhu_air'],$item['waktu_thawing'],$item['paraf']]); }
        fclose($o); exit;
    }

    public function edit($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($header, '/thawing-air')) {
            return $r;
        }

        $data = [
            'header' => $header,
            'items'  => $this->itemModel->where('checklist_thawing_air_id', $id)->findAll(),
            'title'  => 'Edit Thawing Air'
        ];
        return view('thawing_air/edit', $data);
    }

    public function update($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($header, '/thawing-air')) {
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

        $this->itemModel->where('checklist_thawing_air_id', $id)->delete();
        foreach ($items as $item) {
            $this->itemModel->insert([
                'checklist_thawing_air_id' => $id,
                'nama_bahan'    => $item['nama_bahan'],
                'jumlah'        => $item['jumlah'] ?? '',
                'suhu_air'      => $item['suhu_air'] ?? '',
                'waktu_thawing' => $item['waktu_thawing'] ?? '',
                'paraf'         => $item['paraf'] ?? '',
            ]);
        }

        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal memperbarui.')->withInput();
        return redirect()->to('/thawing-air')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }

        $db = \Config\Database::connect();
        $db->transStart();
        $this->itemModel->where('checklist_thawing_air_id', $id)->delete();
        $this->headerModel->delete($id);
        $db->transComplete();

        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal menghapus.');
        return redirect()->to('/thawing-air')->with('success', 'Data berhasil dihapus.');
    }
}
