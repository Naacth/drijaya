<?php

namespace App\Controllers;

use App\Models\CekBahanBakuModel;
use App\Models\CekBahanBakuItemModel;

class CekBahanBakuController extends BaseController
{
    protected $headerModel;
    protected $itemModel;

    public function __construct()
    {
        $this->headerModel = new CekBahanBakuModel();
        $this->itemModel = new CekBahanBakuItemModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $userId = session()->get('user_id');

        $db = \Config\Database::connect();
        $builder = $db->table('cek_bahan_baku');
        $builder->select('cek_bahan_baku.*, users.nama as user_nama');
        $builder->join('users', 'users.id = cek_bahan_baku.created_by');

        if ($role == 'aslap') {
            $builder->where('cek_bahan_baku.created_by', $userId);
        } elseif ($role == 'admin' || $role == 'pic') {
            $currentSppgId = session()->get('sppg_id');
            if ($currentSppgId) {
                $builder->where('users.sppg_id', $currentSppgId);
            }
        }

        $builder->orderBy('cek_bahan_baku.created_at', 'DESC');
        
        $data['title'] = 'Data Pemeriksaan Bahan Makanan';
        $data['forms'] = $builder->get()->getResultArray();

        return view('cek_bahan/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Buat Form Pemeriksaan Bahan Makanan';
        return view('cek_bahan/create', $data);
    }

    public function store()
    {
        $items = $this->request->getPost('items');
        if (empty($items)) {
            return redirect()->back()->with('error', 'Minimal harus mengisi 1 baris bahan makanan.')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $headerData = [
            'tanggal_laporan'  => $this->request->getPost('tanggal_laporan'),
            'nama_sppg'        => $this->request->getPost('nama_sppg'),
            'alamat_sppg'      => $this->request->getPost('alamat_sppg'),
            'nama_kepala_sppg' => $this->request->getPost('nama_kepala_sppg'),
            'created_by'       => session()->get('user_id'),
            'status'           => 'submitted',
        ];

        $headerId = $this->headerModel->insert($headerData);

        foreach ($items as $item) {
            $this->itemModel->insert([
                'cek_bahan_baku_id' => $headerId,
                'tgl_bahan'         => $item['tgl_bahan'],
                'jenis_bahan'       => $item['jenis_bahan'],
                'satuan'            => $item['satuan'],
                'banyaknya'         => $item['banyaknya'],
                'jumlah_sesuai'     => $item['jumlah_sesuai'],
                'kondisi_bahan'     => $item['kondisi_bahan'],
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan formulir.')->withInput();
        }

        return redirect()->to('/cek-bahan-baku')->with('success', 'Formulir Pemeriksaan Bahan Makanan berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('cek_bahan_baku');
        $builder->select('cek_bahan_baku.*, users.nama as user_nama');
        $builder->join('users', 'users.id = cek_bahan_baku.created_by');
        $builder->where('cek_bahan_baku.id', $id);
        $header = $builder->get()->getRowArray();

        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data['header'] = $header;
        $data['items'] = $this->itemModel->where('cek_bahan_baku_id', $id)->findAll();
        $data['title'] = 'Detail Form Pemeriksaan Bahan Makanan';

        return view('cek_bahan/show', $data);
    }

    public function exportPdf($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data['header'] = $header;
        $data['items']  = $this->itemModel->where('cek_bahan_baku_id', $id)->findAll();
        $data['title']  = 'Cetak Pemeriksaan Bahan Makanan';

        return view('cek_bahan/print', $data);
    }

    public function exportExcel($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $items = $this->itemModel->where('cek_bahan_baku_id', $id)->findAll();

        $filename = 'Pemeriksaan_Bahan_Makanan_' . date('Ymd_His') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['FORM PEMERIKSAAN BAHAN MAKANAN - SPPG ' . strtoupper($header['nama_sppg'])]);
        fputcsv($output, ['Tanggal Laporan', $header['tanggal_laporan']]);
        fputcsv($output, ['Alamat SPPG', $header['alamat_sppg']]);
        fputcsv($output, ['Kepala SPPG', $header['nama_kepala_sppg']]);
        fputcsv($output, []);
        
        fputcsv($output, ['No', 'Tgl Bahan', 'Jenis Bahan Makanan', 'Banyaknya', 'Satuan', 'Jumlah Sesuai', 'Kondisi Bahan']);
        
        foreach ($items as $index => $item) {
            fputcsv($output, [
                $index + 1,
                $item['tgl_bahan'],
                $item['jenis_bahan'],
                $item['banyaknya'],
                $item['satuan'],
                $item['jumlah_sesuai'],
                $item['kondisi_bahan']
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
        $this->itemModel->where('cek_bahan_baku_id', $id)->delete();
        $this->headerModel->delete($id);
        $db->transComplete();

        return redirect()->to('/cek-bahan-baku')->with('success', 'Data Pemeriksaan Bahan berhasil dihapus.');
    }
}
