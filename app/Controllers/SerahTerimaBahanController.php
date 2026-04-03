<?php

namespace App\Controllers;

use App\Traits\ChecksAhliGiziOwnership;
use App\Models\SerahTerimaBahanModel;
use App\Models\SerahTerimaBahanItemModel;

class SerahTerimaBahanController extends BaseController
{
    use ChecksAhliGiziOwnership;

    protected $headerModel;
    protected $itemModel;

    public function __construct()
    {
        $this->headerModel = new SerahTerimaBahanModel();
        $this->itemModel   = new SerahTerimaBahanItemModel();
    }

    public function index()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('serah_terima_bahan');
        $builder->select('serah_terima_bahan.*, users.nama as user_nama');
        $builder->join('users', 'users.id = serah_terima_bahan.created_by');
        $role = session()->get('role');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $builder->where('serah_terima_bahan.created_by', session()->get('user_id'));
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $builder->where('users.sppg_id', $sppgId);
        }
        $builder->orderBy('serah_terima_bahan.created_at', 'DESC');
        $data['title'] = 'Serah Terima Bahan Baku';
        $data['forms'] = $builder->get()->getResultArray();
        return view('serah_terima_bahan/index', $data);
    }

    public function create() { return view('serah_terima_bahan/create', ['title' => 'Buat Form Serah Terima Bahan']); }

    public function store()
    {
        $items = $this->request->getPost('items');
        if (empty($items)) return redirect()->back()->with('error', 'Minimal 1 baris.')->withInput();
        $db = \Config\Database::connect(); $db->transStart();
        $headerId = $this->headerModel->insert([
            'tanggal' => $this->request->getPost('tanggal'),
            'nama_pengirim' => $this->request->getPost('nama_pengirim'),
            'nama_penerima' => $this->request->getPost('nama_penerima'),
            'created_by' => session()->get('user_id'),
        ]);
        foreach ($items as $item) {
            $this->itemModel->insert([
                'serah_terima_bahan_id' => $headerId,
                'jam' => $item['jam'] ?? '', 'nama_bahan' => $item['nama_bahan'],
                'tujuan_penggunaan' => $item['tujuan_penggunaan'] ?? '',
                'gramasi_per_porsi' => $item['gramasi_per_porsi'] ?? '',
                'jumlah_awal' => $item['jumlah_awal'] ?? '',
                'jumlah_tidak_layak' => $item['jumlah_tidak_layak'] ?? '',
                'tindak_lanjut' => $item['tindak_lanjut'] ?? '',
                'jumlah_akhir' => $item['jumlah_akhir'] ?? '',
            ]);
        }
        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal menyimpan.')->withInput();
        return redirect()->to('/serah-terima-bahan')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect(); $b = $db->table('serah_terima_bahan');
        $b->select('serah_terima_bahan.*, users.nama as user_nama')->join('users', 'users.id = serah_terima_bahan.created_by')->where('serah_terima_bahan.id', $id);
        $header = $b->get()->getRowArray();
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('serah_terima_bahan/show', ['header' => $header, 'items' => $this->itemModel->where('serah_terima_bahan_id', $id)->findAll(), 'title' => 'Detail Serah Terima Bahan']);
    }

    public function exportPdf($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('serah_terima_bahan/print', ['header' => $header, 'items' => $this->itemModel->where('serah_terima_bahan_id', $id)->findAll(), 'title' => 'Cetak Serah Terima Bahan', 'signature' => signature_row_for_pdf(isset($header['created_by']) ? (int) $header['created_by'] : null)]);
    }

    public function exportPdfBlank()
    {
        helper('print');
        $items = [];
        for ($i = 0; $i < 10; $i++) {
            $items[] = [
                'jam'                   => '',
                'nama_bahan'            => '',
                'tujuan_penggunaan'     => '',
                'gramasi_per_porsi'     => '',
                'jumlah_awal'           => '',
                'jumlah_tidak_layak'    => '',
                'tindak_lanjut'         => '',
                'jumlah_akhir'          => '',
            ];
        }

        return view('serah_terima_bahan/print', [
            'blank'     => true,
            'header'    => ['tanggal' => '', 'nama_pengirim' => '', 'nama_penerima' => '', 'created_by' => null],
            'items'     => $items,
            'title'     => 'Form Serah Terima Bahan (kosong)',
            'signature' => signature_row_for_pdf(null),
        ]);
    }

    public function exportExcel($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $items = $this->itemModel->where('serah_terima_bahan_id', $id)->findAll();
        $filename = 'Serah_Terima_Bahan_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        $o = fopen('php://output', 'w'); fprintf($o, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($o, ['SERAH TERIMA BAHAN BAKU']); fputcsv($o, ['Tanggal', $header['tanggal']]); fputcsv($o, []);
        fputcsv($o, ['No','Jam','Nama Bahan','Tujuan','Gramasi/Porsi','Jml Awal','Jml Tidak Layak','Tindak Lanjut','Jml Akhir']);
        foreach ($items as $i => $item) { fputcsv($o, [$i+1,$item['jam'],$item['nama_bahan'],$item['tujuan_penggunaan'],$item['gramasi_per_porsi'],$item['jumlah_awal'],$item['jumlah_tidak_layak'],$item['tindak_lanjut'],$item['jumlah_akhir']]); }
        fclose($o); exit;
    }

    public function edit($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($header, '/serah-terima-bahan')) {
            return $r;
        }

        $data = [
            'header' => $header,
            'items'  => $this->itemModel->where('serah_terima_bahan_id', $id)->findAll(),
            'title'  => 'Edit Serah Terima Bahan'
        ];
        return view('serah_terima_bahan/edit', $data);
    }

    public function update($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($header, '/serah-terima-bahan')) {
            return $r;
        }

        $items = $this->request->getPost('items');
        if (empty($items)) return redirect()->back()->with('error', 'Minimal 1 baris.')->withInput();

        $db = \Config\Database::connect();
        $db->transStart();

        $this->headerModel->update($id, [
            'tanggal'       => $this->request->getPost('tanggal'),
            'nama_pengirim' => $this->request->getPost('nama_pengirim'),
            'nama_penerima' => $this->request->getPost('nama_penerima'),
        ]);

        $this->itemModel->where('serah_terima_bahan_id', $id)->delete();
        foreach ($items as $item) {
            $this->itemModel->insert([
                'serah_terima_bahan_id' => $id,
                'jam' => $item['jam'] ?? '', 
                'nama_bahan' => $item['nama_bahan'],
                'tujuan_penggunaan' => $item['tujuan_penggunaan'] ?? '',
                'gramasi_per_porsi' => $item['gramasi_per_porsi'] ?? '',
                'jumlah_awal' => $item['jumlah_awal'] ?? '',
                'jumlah_tidak_layak' => $item['jumlah_tidak_layak'] ?? '',
                'tindak_lanjut' => $item['tindak_lanjut'] ?? '',
                'jumlah_akhir' => $item['jumlah_akhir'] ?? '',
            ]);
        }

        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal memperbarui.')->withInput();
        return redirect()->to('/serah-terima-bahan')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }

        $db = \Config\Database::connect();
        $db->transStart();
        $this->itemModel->where('serah_terima_bahan_id', $id)->delete();
        $this->headerModel->delete($id);
        $db->transComplete();

        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal menghapus.');
        return redirect()->to('/serah-terima-bahan')->with('success', 'Data berhasil dihapus.');
    }
}
