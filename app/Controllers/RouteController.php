<?php

namespace App\Controllers;

use App\Models\RouteModel;
use App\Models\RouteItemModel;

class RouteController extends BaseController
{
    protected $routeModel;
    protected $itemModel;

    public function __construct()
    {
        $this->routeModel = new RouteModel();
        $this->itemModel = new RouteItemModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $userId = session()->get('user_id');

        $status = $this->request->getGet('status');
        $search = $this->request->getGet('search');

        $query = $this->routeModel->getWithCreator();

        if ($role == 'aslap') {
            $query->where('routes.created_by', $userId);
        }

        if ($status) {
            $query->where('routes.status', $status);
        }

        if ($search) {
            $query->groupStart()
                  ->like('routes.mobil', $search)
                  ->orLike('routes.driver', $search)
                  ->orLike('routes.sppg', $search)
                  ->orLike('routes.kecamatan', $search)
                  ->groupEnd();
        }

        $data['title'] = 'Data Rute Pengiriman';
        $data['items'] = $query->paginate(10, 'routes');
        $data['pager'] = $this->routeModel->pager;
        $data['filter'] = ['status' => $status, 'search' => $search];

        return view('route/index', $data);
    }

    public function create()
    {
        if (session()->get('role') != 'aslap') {
            return redirect()->to('/routes')->with('error', 'Unauthorized');
        }

        $data['title'] = 'Buat Rute Pengiriman Baru';
        return view('route/create', $data);
    }

    public function store()
    {
        $role = session()->get('role');
        if ($role != 'aslap') {
            return redirect()->to('/routes')->with('error', 'Unauthorized');
        }

        $items = $this->request->getPost('items');
        if (empty($items)) {
            return redirect()->back()->with('error', 'Minimal harus ada 1 sekolah dalam rute.')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $headerData = [
            'tanggal'    => $this->request->getPost('tanggal'),
            'sppg'       => $this->request->getPost('sppg'),
            'kecamatan'  => $this->request->getPost('kecamatan'),
            'mobil'      => $this->request->getPost('mobil'),
            'driver'     => $this->request->getPost('driver'),
            'created_by' => session()->get('user_id'),
            'status'     => ($this->request->getPost('action') == 'submit') ? 'submitted' : 'draft',
            'total_porsi' => 0, // Will be updated below
        ];

        $routeId = $this->routeModel->insert($headerData);
        $totalPorsiMobil = 0;

        foreach ($items as $item) {
            $porsiBesar = (int)$item['porsi_besar'];
            $porsiKecil = (int)$item['porsi_kecil'];
            $jumlah = $porsiBesar + $porsiKecil;
            
            $totalPorsiMobil += $jumlah;

            $this->itemModel->insert([
                'route_id'     => $routeId,
                'nama_sekolah' => $item['nama_sekolah'],
                'porsi_besar'  => $porsiBesar,
                'porsi_kecil'  => $porsiKecil,
                'jumlah'       => $jumlah,
                'jam_antar'    => $item['jam_antar'],
                'sesi'         => $item['sesi']
            ]);
        }

        // Update total porsi in header
        $this->routeModel->update($routeId, ['total_porsi' => $totalPorsiMobil]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan rute.')->withInput();
        }

        return redirect()->to('/routes')->with('success', 'Rute berhasil disimpan.');
    }

    public function edit($id)
    {
        $route = $this->routeModel->find($id);
        if (!$route || ($route['created_by'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->to('/routes')->with('error', 'Unauthorized or not found.');
        }

        if ($route['status'] == 'approved') {
            return redirect()->back()->with('error', 'Data yang sudah disetujui tidak dapat diubah.');
        }

        $data['title'] = 'Edit Rute Pengiriman';
        $data['header'] = $route;
        $data['items'] = $this->itemModel->where('route_id', $id)->findAll();

        return view('route/edit', $data);
    }

    public function update($id)
    {
        $route = $this->routeModel->find($id);
        if (!$route || ($route['created_by'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->to('/routes')->with('error', 'Unauthorized.');
        }

        $items = $this->request->getPost('items');
        if (empty($items)) {
            return redirect()->back()->with('error', 'Minimal harus ada 1 sekolah.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $headerData = [
            'tanggal'    => $this->request->getPost('tanggal'),
            'sppg'       => $this->request->getPost('sppg'),
            'kecamatan'  => $this->request->getPost('kecamatan'),
            'mobil'      => $this->request->getPost('mobil'),
            'driver'     => $this->request->getPost('driver'),
            'status'     => ($this->request->getPost('action') == 'submit') ? 'submitted' : 'draft',
        ];

        $this->routeModel->update($id, $headerData);

        // Delete existing items and re-insert
        $this->itemModel->where('route_id', $id)->delete();

        $totalPorsiMobil = 0;
        foreach ($items as $item) {
            $porsiBesar = (int)$item['porsi_besar'];
            $porsiKecil = (int)$item['porsi_kecil'];
            $jumlah = $porsiBesar + $porsiKecil;
            $totalPorsiMobil += $jumlah;

            $this->itemModel->insert([
                'route_id'     => $id,
                'nama_sekolah' => $item['nama_sekolah'],
                'porsi_besar'  => $porsiBesar,
                'porsi_kecil'  => $porsiKecil,
                'jumlah'       => $jumlah,
                'jam_antar'    => $item['jam_antar'],
                'sesi'         => $item['sesi']
            ]);
        }

        $this->routeModel->update($id, ['total_porsi' => $totalPorsiMobil]);

        $db->transComplete();

        return redirect()->to('/routes')->with('success', 'Rute berhasil diperbarui.');
    }

    public function delete($id)
    {
        $route = $this->routeModel->find($id);
        if (!$route || ($route['created_by'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->to('/routes')->with('error', 'Unauthorized.');
        }

        if ($route['status'] == 'approved' && session()->get('role') != 'admin') {
            return redirect()->back()->with('error', 'Data yang sudah disetujui tidak dapat dihapus.');
        }

        $this->routeModel->delete($id); // cascade will handle route_items if set, otherwise manually delete
        return redirect()->to('/routes')->with('success', 'Rute berhasil dihapus.');
    }

    public function show($id)
    {
        $data['header'] = $this->routeModel->getWithCreator()->find($id);
        $data['items'] = $this->itemModel->where('route_id', $id)->findAll();
        $data['title'] = 'Detail Rute Pengiriman';

        return view('route/show', $data);
    }

    public function approve($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $this->routeModel->update($id, ['status' => 'approved']);
        return redirect()->back()->with('success', 'Rute disetujui.');
    }

    public function reject($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $this->routeModel->update($id, ['status' => 'rejected']);
        return redirect()->back()->with('success', 'Rute ditolak.');
    }

    public function exportPdf($id)
    {
        $data['header'] = $this->routeModel->getWithCreator()->find($id);
        $data['items'] = $this->itemModel->where('route_id', $id)->findAll();
        $data['title'] = 'Laporan Rute Pengiriman (NEW RUTE)';

        return view('route/export_pdf', $data);
    }

    public function exportPdfBlank()
    {
        helper('print');
        $items = [];
        for ($i = 0; $i < 12; $i++) {
            $items[] = [
                'nama_sekolah' => '',
                'porsi_besar'  => '',
                'porsi_kecil'  => '',
                'jumlah'       => '',
                'jam_antar'    => '',
                'sesi'         => '',
            ];
        }

        return view('route/export_pdf', [
            'blank'  => true,
            'header' => [
                'tanggal'     => '',
                'sppg'        => '',
                'mobil'       => '',
                'kecamatan'   => '',
                'driver'      => '',
                'status'      => '',
                'total_porsi' => '',
            ],
            'items'  => $items,
            'title'  => 'Alur Pengiriman (form kosong)',
        ]);
    }

    public function suratJalanPdf($id)
    {
        $header = $this->routeModel->getWithCreator()->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $items = $this->itemModel->where('route_id', $id)->findAll();
        
        // Find signatures for this SPPG
        $sigModel = new \App\Models\SignatureModel();
        $signature = $sigModel->where('sppg_name', $header['sppg'])->first();

        // If not found, create empty object so view doesn't break
        if (!$signature) {
            $signature = [
                'nama_akuntan' => '.........................',
                'ttd_akuntan' => null,
                'nama_ahli_gizi' => '.........................',
                'ttd_ahli_gizi' => null,
                'nama_kepala_dapur' => '.........................',
                'ttd_kepala_dapur' => null,
            ];
        }

        $data = [
            'title'           => 'SURAT JALAN / DELIVERY ORDER',
            'header'          => $header,
            'items'           => $items,
            'signature'       => $signature,
            'user_signature'  => signature_row_for_pdf(isset($header['created_by']) ? (int) $header['created_by'] : null),
        ];

        return view('route/surat_jalan', $data);
    }

    public function exportExcel($id)
    {
        $header = $this->routeModel->getWithCreator()->find($id);
        $items = $this->itemModel->where('route_id', $id)->findAll();

        $filename = 'Rute_Pengiriman_' . date('Ymd_His') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['NEW RUTE - ALUR PENGIRIMAN']);
        fputcsv($output, ['Tanggal', $header['tanggal']]);
        fputcsv($output, ['SPPG', $header['sppg']]);
        fputcsv($output, ['Mobil', $header['mobil']]);
        fputcsv($output, ['Driver', $header['driver']]);
        fputcsv($output, []);
        
        fputcsv($output, ['No', 'Nama Sekolah', 'Porsi Besar', 'Porsi Kecil', 'Jumlah', 'Jam Antar', 'Sesi']);
        
        foreach ($items as $index => $item) {
            fputcsv($output, [
                $index + 1,
                $item['nama_sekolah'],
                $item['porsi_besar'],
                $item['porsi_kecil'],
                $item['jumlah'],
                $item['jam_antar'],
                $item['sesi']
            ]);
        }
        
        fputcsv($output, []);
        fputcsv($output, ['', 'TOTAL SELURUH', '', '', $header['total_porsi']]);
        
        fclose($output);
        exit;
    }
}
