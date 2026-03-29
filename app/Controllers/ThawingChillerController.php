<?php

namespace App\Controllers;

use App\Models\ThawingChillerModel;
use App\Models\ThawingChillerItemModel;

class ThawingChillerController extends BaseController
{
    protected $headerModel;
    protected $itemModel;

    public function __construct()
    {
        $this->headerModel = new ThawingChillerModel();
        $this->itemModel   = new ThawingChillerItemModel();
    }

    public function index()
    {
        $db = \Config\Database::connect(); $b = $db->table('monitoring_thawing_chiller');
        $b->select('monitoring_thawing_chiller.*, users.nama as user_nama')->join('users', 'users.id = monitoring_thawing_chiller.created_by');
        $role = session()->get('role');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $b->where('monitoring_thawing_chiller.created_by', session()->get('user_id'));
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $b->where('users.sppg_id', $sppgId);
        }
        $b->orderBy('monitoring_thawing_chiller.created_at', 'DESC');
        return view('thawing_chiller/index', ['title' => 'Monitoring Thawing Chiller', 'forms' => $b->get()->getResultArray()]);
    }

    public function create() { return view('thawing_chiller/create', ['title' => 'Buat Form Thawing Chiller']); }

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
                'monitoring_thawing_chiller_id' => $headerId,
                'nama_bahan' => $item['nama_bahan'],
                'jumlah' => $item['jumlah'] ?? '',
                'tgl_jam_keluar_freezer' => $item['tgl_jam_keluar_freezer'] ?? '',
                'tgl_jam_selesai_thawing' => $item['tgl_jam_selesai_thawing'] ?? '',
                'tgl_jam_pemasakan' => $item['tgl_jam_pemasakan'] ?? '',
                'paraf' => $item['paraf'] ?? '',
            ]);
        }
        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal menyimpan.')->withInput();
        return redirect()->to('/thawing-chiller')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect(); $b = $db->table('monitoring_thawing_chiller');
        $b->select('monitoring_thawing_chiller.*, users.nama as user_nama')->join('users', 'users.id = monitoring_thawing_chiller.created_by')->where('monitoring_thawing_chiller.id', $id);
        $header = $b->get()->getRowArray();
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('thawing_chiller/show', ['header' => $header, 'items' => $this->itemModel->where('monitoring_thawing_chiller_id', $id)->findAll(), 'title' => 'Detail Thawing Chiller']);
    }

    public function exportPdf($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('thawing_chiller/print', ['header' => $header, 'items' => $this->itemModel->where('monitoring_thawing_chiller_id', $id)->findAll(), 'title' => 'Cetak Thawing Chiller', 'signature' => (new \App\Models\UserSignatureModel())->where('user_id', $header['created_by'])->first()]);
    }

    public function exportExcel($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $items = $this->itemModel->where('monitoring_thawing_chiller_id', $id)->findAll();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Thawing_Chiller_' . date('Ymd_His') . '.csv');
        $o = fopen('php://output', 'w'); fprintf($o, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($o, ['MONITORING THAWING CHILLER']); fputcsv($o, ['Tanggal', $header['tanggal']]); fputcsv($o, []);
        fputcsv($o, ['No','Nama Bahan','Jumlah','Tgl/Jam Keluar Freezer','Tgl/Jam Selesai Thawing','Tgl/Jam Pemasakan','Paraf']);
        foreach ($items as $i => $item) { fputcsv($o, [$i+1,$item['nama_bahan'],$item['jumlah'],$item['tgl_jam_keluar_freezer'],$item['tgl_jam_selesai_thawing'],$item['tgl_jam_pemasakan'],$item['paraf']]); }
        fclose($o); exit;
    }

    public function edit($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        
        $data = [
            'header' => $header,
            'items'  => $this->itemModel->where('monitoring_thawing_chiller_id', $id)->findAll(),
            'title'  => 'Edit Thawing Chiller'
        ];
        return view('thawing_chiller/edit', $data);
    }

    public function update($id)
    {
        $items = $this->request->getPost('items');
        if (empty($items)) return redirect()->back()->with('error', 'Minimal 1 baris.')->withInput();

        $db = \Config\Database::connect();
        $db->transStart();

        $this->headerModel->update($id, [
            'tanggal'      => $this->request->getPost('tanggal'),
            'nama_petugas' => $this->request->getPost('nama_petugas'),
        ]);

        $this->itemModel->where('monitoring_thawing_chiller_id', $id)->delete();
        foreach ($items as $item) {
            $this->itemModel->insert([
                'monitoring_thawing_chiller_id' => $id,
                'nama_bahan'              => $item['nama_bahan'],
                'jumlah'                  => $item['jumlah'] ?? '',
                'tgl_jam_keluar_freezer'  => $item['tgl_jam_keluar_freezer'] ?? '',
                'tgl_jam_selesai_thawing' => $item['tgl_jam_selesai_thawing'] ?? '',
                'tgl_jam_pemasakan'       => $item['tgl_jam_pemasakan'] ?? '',
                'paraf'                   => $item['paraf'] ?? '',
            ]);
        }

        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal memperbarui.')->withInput();
        return redirect()->to('/thawing-chiller')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }

        $db = \Config\Database::connect();
        $db->transStart();
        $this->itemModel->where('monitoring_thawing_chiller_id', $id)->delete();
        $this->headerModel->delete($id);
        $db->transComplete();

        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal menghapus.');
        return redirect()->to('/thawing-chiller')->with('success', 'Data berhasil dihapus.');
    }
}
