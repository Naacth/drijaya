<?php

namespace App\Controllers;

use App\Models\MonitoringSuhuMasakModel;
use App\Models\MonitoringSuhuMasakItemModel;

class MonitoringSuhuMasakController extends BaseController
{
    protected $headerModel;
    protected $itemModel;

    public function __construct()
    {
        $this->headerModel = new MonitoringSuhuMasakModel();
        $this->itemModel   = new MonitoringSuhuMasakItemModel();
    }

    public function index()
    {
        $db = \Config\Database::connect(); $b = $db->table('monitoring_suhu_masak');
        $b->select('monitoring_suhu_masak.*, users.nama as user_nama')->join('users', 'users.id = monitoring_suhu_masak.created_by');
        $role = session()->get('role');
        if ($role == 'ahli_gizi') $b->where('monitoring_suhu_masak.created_by', session()->get('user_id'));
        elseif ($role == 'admin') { $s = session()->get('sppg_id'); if ($s) $b->where('users.sppg_id', $s); }
        $b->orderBy('monitoring_suhu_masak.created_at', 'DESC');
        return view('monitoring_suhu_masak/index', ['title' => 'Monitoring Suhu Pemasakan', 'forms' => $b->get()->getResultArray()]);
    }

    public function create() { return view('monitoring_suhu_masak/create', ['title' => 'Buat Form Monitoring Suhu']); }

    public function store()
    {
        $items = $this->request->getPost('items');
        if (empty($items)) return redirect()->back()->with('error', 'Minimal 1 baris.')->withInput();
        $db = \Config\Database::connect(); $db->transStart();
        $headerId = $this->headerModel->insert([
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_pelaksana' => $this->request->getPost('nama_pelaksana'),
            'nama_pemeriksa' => $this->request->getPost('nama_pemeriksa'),
            'created_by' => session()->get('user_id'),
        ]);
        foreach ($items as $item) {
            $this->itemModel->insert([
                'monitoring_suhu_masak_id' => $headerId,
                'nama_makanan' => $item['nama_makanan'],
                'suhu_pemasakan' => $item['suhu_pemasakan'] ?? '',
                'jam_matang' => $item['jam_matang'] ?? '',
                'jadwal_penyajian' => $item['jadwal_penyajian'] ?? '',
            ]);
        }
        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal menyimpan.')->withInput();
        return redirect()->to('/monitoring-suhu-masak')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect(); $b = $db->table('monitoring_suhu_masak');
        $b->select('monitoring_suhu_masak.*, users.nama as user_nama')->join('users', 'users.id = monitoring_suhu_masak.created_by')->where('monitoring_suhu_masak.id', $id);
        $header = $b->get()->getRowArray();
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('monitoring_suhu_masak/show', ['header' => $header, 'items' => $this->itemModel->where('monitoring_suhu_masak_id', $id)->findAll(), 'title' => 'Detail Monitoring Suhu']);
    }

    public function exportPdf($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('monitoring_suhu_masak/print', ['header' => $header, 'items' => $this->itemModel->where('monitoring_suhu_masak_id', $id)->findAll(), 'title' => 'Cetak Monitoring Suhu', 'signature' => (new \App\Models\UserSignatureModel())->where('user_id', $header['created_by'])->first()]);
    }

    public function exportExcel($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $items = $this->itemModel->where('monitoring_suhu_masak_id', $id)->findAll();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Monitoring_Suhu_Masak_' . date('Ymd_His') . '.csv');
        $o = fopen('php://output', 'w'); fprintf($o, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($o, ['MONITORING SUHU PEMASAKAN']); fputcsv($o, ['Tanggal', $header['tanggal']]); fputcsv($o, []);
        fputcsv($o, ['No','Nama Makanan','Suhu Pemasakan','Jam Matang','Jadwal Penyajian']);
        foreach ($items as $i => $item) { fputcsv($o, [$i+1,$item['nama_makanan'],$item['suhu_pemasakan'],$item['jam_matang'],$item['jadwal_penyajian']]); }
        fclose($o); exit;
    }

    public function edit($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        
        $data = [
            'header' => $header,
            'items'  => $this->itemModel->where('monitoring_suhu_masak_id', $id)->findAll(),
            'title'  => 'Edit Monitoring Suhu Pemasakan'
        ];
        return view('monitoring_suhu_masak/edit', $data);
    }

    public function update($id)
    {
        $items = $this->request->getPost('items');
        if (empty($items)) return redirect()->back()->with('error', 'Minimal 1 baris.')->withInput();

        $db = \Config\Database::connect();
        $db->transStart();

        $this->headerModel->update($id, [
            'tanggal'        => $this->request->getPost('tanggal'),
            'nama_pelaksana' => $this->request->getPost('nama_pelaksana'),
            'nama_pemeriksa' => $this->request->getPost('nama_pemeriksa'),
        ]);

        $this->itemModel->where('monitoring_suhu_masak_id', $id)->delete();
        foreach ($items as $item) {
            $this->itemModel->insert([
                'monitoring_suhu_masak_id' => $id,
                'nama_makanan'     => $item['nama_makanan'],
                'suhu_pemasakan'   => $item['suhu_pemasakan'] ?? '',
                'jam_matang'       => $item['jam_matang'] ?? '',
                'jadwal_penyajian' => $item['jadwal_penyajian'] ?? '',
            ]);
        }

        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal memperbarui.')->withInput();
        return redirect()->to('/monitoring-suhu-masak')->with('success', 'Data berhasil diperbarui.');
    }
}
