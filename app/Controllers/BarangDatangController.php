<?php

namespace App\Controllers;

use App\Models\BarangDatangModel;
use App\Models\BarangDatangItemModel;
use App\Traits\ChecksAslapOwnsRecord;

class BarangDatangController extends BaseController
{
    use ChecksAslapOwnsRecord;

    protected $headerModel;
    protected $itemModel;

    public function __construct()
    {
        $this->headerModel = new BarangDatangModel();
        $this->itemModel = new BarangDatangItemModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $userId = session()->get('user_id');

        // Custom query to join users table
        $db = \Config\Database::connect();
        $builder = $db->table('barang_datang');
        $builder->select('barang_datang.*, users.nama as user_nama');
        $builder->join('users', 'users.id = barang_datang.created_by');

        if ($role == 'aslap') {
            $builder->where('barang_datang.created_by', $userId);
        } elseif ($role == 'admin' || $role == 'pic') {
            $currentSppgId = session()->get('sppg_id');
            if ($currentSppgId) {
                $builder->where('users.sppg_id', $currentSppgId);
            }
        }

        $builder->orderBy('barang_datang.created_at', 'DESC');
        
        $data['title'] = 'Data Formulir Barang Datang';
        $data['forms'] = $builder->get()->getResultArray();

        return view('barang_datang/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Buat Formulir Barang Datang';
        return view('barang_datang/create', $data);
    }

    public function store()
    {
        $items = $this->request->getPost('items');
        if (empty($items)) {
            return redirect()->back()->with('error', 'Minimal harus mengisi 1 barang.')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $headerData = [
            'tanggal'          => $this->request->getPost('tanggal'),
            'penanggung_jawab' => $this->request->getPost('penanggung_jawab'),
            'created_by'       => session()->get('user_id'),
            'status'           => 'submitted',
        ];

        $headerId = $this->headerModel->insert($headerData);

        foreach ($items as $item) {
            $this->itemModel->insert([
                'barang_datang_id' => $headerId,
                'nama_barang'      => $item['nama_barang'],
                'satuan'           => $item['satuan'],
                'banyak_barang'    => $item['banyak_barang'],
                'keterangan'       => $item['keterangan'] ?? null,
                'nama_qc'          => $item['nama_qc'] ?? null,
                'nama_pemasok'     => $item['nama_pemasok'] ?? null,
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan formulir.')->withInput();
        }

        return redirect()->to('/barang-datang')->with('success', 'Formulir Barang Datang berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('barang_datang');
        $builder->select('barang_datang.*, users.nama as user_nama');
        $builder->join('users', 'users.id = barang_datang.created_by');
        $builder->where('barang_datang.id', $id);
        $header = $builder->get()->getRowArray();

        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if ($r = $this->redirectIfAslapCannotAccessRecord($header, '/barang-datang')) {
            return $r;
        }

        $data['header'] = $header;
        $data['items'] = $this->itemModel->where('barang_datang_id', $id)->findAll();
        $data['title'] = 'Detail Formulir Barang Datang';

        return view('barang_datang/show', $data);
    }

    public function edit($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('barang_datang');
        $builder->select('barang_datang.*, users.nama as user_nama');
        $builder->join('users', 'users.id = barang_datang.created_by');
        $builder->where('barang_datang.id', $id);
        $header = $builder->get()->getRowArray();

        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if ($r = $this->redirectIfAslapCannotAccessRecord($header, '/barang-datang')) {
            return $r;
        }

        $data['header'] = $header;
        $data['items'] = $this->itemModel->where('barang_datang_id', $id)->findAll();
        $data['title'] = 'Ubah Formulir Barang Datang';

        return view('barang_datang/edit', $data);
    }

    public function update($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if ($r = $this->redirectIfAslapCannotAccessRecord($header, '/barang-datang')) {
            return $r;
        }

        $items = $this->request->getPost('items');
        if (empty($items)) {
            return redirect()->back()->with('error', 'Minimal harus mengisi 1 barang.')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->headerModel->update($id, [
            'tanggal'          => $this->request->getPost('tanggal'),
            'penanggung_jawab' => $this->request->getPost('penanggung_jawab'),
        ]);

        $this->itemModel->where('barang_datang_id', $id)->delete();

        foreach ($items as $item) {
            $this->itemModel->insert([
                'barang_datang_id' => $id,
                'nama_barang'      => $item['nama_barang'],
                'satuan'           => $item['satuan'],
                'banyak_barang'    => $item['banyak_barang'],
                'keterangan'       => $item['keterangan'] ?? null,
                'nama_qc'          => $item['nama_qc'] ?? null,
                'nama_pemasok'     => $item['nama_pemasok'] ?? null,
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memperbarui formulir.')->withInput();
        }

        return redirect()->to('/barang-datang/show/' . $id)->with('success', 'Formulir Barang Datang berhasil diperbarui.');
    }

    public function exportPdf($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data['header'] = $header;
        $data['items'] = $this->itemModel->where('barang_datang_id', $id)->findAll();
        $data['title'] = 'Cetak Formulir Barang Datang';

        return view('barang_datang/print', $data);
    }

    public function exportExcel($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $items = $this->itemModel->where('barang_datang_id', $id)->findAll();

        $filename = 'Barang_Datang_' . date('Ymd_His') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        
        $output = fopen('php://output', 'w');
        // Add BOM for Excel UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['FORMULIR DATANG BARANG UNIT PELAYANAN GIZI']);
        fputcsv($output, ['Tanggal', $header['tanggal']]);
        fputcsv($output, ['Penanggung Jawab', $header['penanggung_jawab']]);
        fputcsv($output, []);
        
        fputcsv($output, ['No', 'Nama Barang', 'Satuan', 'Banyak Barang', 'TTD QC / Penerima', 'TTD Pemasok', 'Keterangan']);
        
        foreach ($items as $index => $item) {
            fputcsv($output, [
                $index + 1,
                $item['nama_barang'],
                $item['satuan'],
                $item['banyak_barang'],
                $item['nama_qc'] ?? '',
                $item['nama_pemasok'] ?? '',
                $item['keterangan']
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
        $this->itemModel->where('barang_datang_id', $id)->delete();
        $this->headerModel->delete($id);
        $db->transComplete();

        return redirect()->to('/barang-datang')->with('success', 'Data berhasil dihapus.');
    }
}
