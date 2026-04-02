<?php
namespace App\Controllers;

use App\Models\StokOpnameModel;
use App\Models\StokOpnameItemModel;
use App\Traits\ChecksAslapOwnsRecord;

class StokOpnameController extends BaseController
{
    use ChecksAslapOwnsRecord;

    protected $headerModel;
    protected $itemModel;

    public function __construct()
    {
        $this->headerModel = new StokOpnameModel();
        $this->itemModel   = new StokOpnameItemModel();
    }

    public function index()
    {
        $role   = session()->get('role');
        $userId = session()->get('user_id');

        $db = \Config\Database::connect();
        $builder = $db->table('stok_opname');
        $builder->select('stok_opname.*, users.nama as user_nama');
        $builder->join('users', 'users.id = stok_opname.created_by');

        if ($role == 'aslap') {
            $builder->where('stok_opname.created_by', $userId);
        } elseif ($role == 'admin' || $role == 'pic') {
            $currentSppgId = session()->get('sppg_id');
            if ($currentSppgId) {
                $builder->where('users.sppg_id', $currentSppgId);
            }
        }
        $builder->orderBy('stok_opname.created_at', 'DESC');

        $data['title'] = 'Stok Opname';
        $data['forms'] = $builder->get()->getResultArray();
        $data['is_friday'] = (date('N') == 5); // 5 = Friday

        return view('stok_opname/index', $data);
    }

    public function create()
    {
        // Check if today is Friday
        if (date('N') != 5) {
            return redirect()->to('/stok-opname')->with('error', 'Stok Opname hanya bisa diinput pada hari Jumat.');
        }

        $data['title'] = 'Input Stok Opname';
        return view('stok_opname/create', $data);
    }

    public function store()
    {
        $days = $this->request->getPost('days');
        if (empty($days)) {
            return redirect()->back()->with('error', 'Minimal harus mengisi 1 hari.')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $headerId = $this->headerModel->insert([
            'nama_sppg'       => $this->request->getPost('nama_sppg'),
            'kelurahan_desa'  => $this->request->getPost('kelurahan_desa'),
            'kecamatan'       => $this->request->getPost('kecamatan'),
            'kabupaten_kota'  => $this->request->getPost('kabupaten_kota'),
            'provinsi'        => $this->request->getPost('provinsi'),
            'periode_awal'    => $this->request->getPost('periode_awal'),
            'periode_akhir'   => $this->request->getPost('periode_akhir'),
            'nama_kepala_sppg'=> $this->request->getPost('nama_kepala_sppg'),
            'nama_akuntan'    => $this->request->getPost('nama_akuntan'),
            'created_by'      => session()->get('user_id'),
        ]);

        foreach ($days as $dayNum => $items) {
            if (!is_array($items)) continue;
            foreach ($items as $item) {
                if (empty($item['nama_bahan'])) continue;
                $this->itemModel->insert([
                    'stok_opname_id' => $headerId,
                    'hari_ke'        => $dayNum,
                    'nama_bahan'     => $item['nama_bahan'],
                    'satuan'         => $item['satuan'] ?? '',
                    'stok_fisik'     => $item['stok_fisik'] ?? '',
                    'stok_di_kartu'  => $item['stok_di_kartu'] ?? '',
                    'selisih'        => $item['selisih'] ?? '',
                    'keterangan'     => $item['keterangan'] ?? '',
                ]);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan.')->withInput();
        }

        return redirect()->to('/stok-opname')->with('success', 'Stok Opname berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('stok_opname');
        $builder->select('stok_opname.*, users.nama as user_nama');
        $builder->join('users', 'users.id = stok_opname.created_by');
        $builder->where('stok_opname.id', $id);
        $header = $builder->get()->getRowArray();

        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if ($r = $this->redirectIfAslapCannotAccessRecord($header, '/stok-opname')) {
            return $r;
        }

        $allItems = $this->itemModel->where('stok_opname_id', $id)->orderBy('hari_ke', 'ASC')->findAll();
        // Group by hari_ke
        $grouped = [];
        foreach ($allItems as $item) {
            $grouped[$item['hari_ke']][] = $item;
        }

        $data['header'] = $header;
        $data['grouped_items'] = $grouped;
        $data['title'] = 'Detail Stok Opname';

        return view('stok_opname/show', $data);
    }

    public function edit($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('stok_opname');
        $builder->select('stok_opname.*, users.nama as user_nama');
        $builder->join('users', 'users.id = stok_opname.created_by');
        $builder->where('stok_opname.id', $id);
        $header = $builder->get()->getRowArray();

        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if ($r = $this->redirectIfAslapCannotAccessRecord($header, '/stok-opname')) {
            return $r;
        }

        $allItems = $this->itemModel->where('stok_opname_id', $id)->orderBy('hari_ke', 'ASC')->findAll();
        $grouped = [];
        foreach ($allItems as $item) {
            $grouped[$item['hari_ke']][] = $item;
        }
        ksort($grouped, SORT_NUMERIC);

        $data['header'] = $header;
        $data['grouped_items'] = $grouped;
        $data['title'] = 'Ubah Stok Opname';

        return view('stok_opname/edit', $data);
    }

    public function update($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if ($r = $this->redirectIfAslapCannotAccessRecord($header, '/stok-opname')) {
            return $r;
        }

        $days = $this->request->getPost('days');
        if (empty($days)) {
            return redirect()->back()->with('error', 'Minimal harus mengisi 1 hari.')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->headerModel->update($id, [
            'nama_sppg'        => $this->request->getPost('nama_sppg'),
            'kelurahan_desa'   => $this->request->getPost('kelurahan_desa'),
            'kecamatan'        => $this->request->getPost('kecamatan'),
            'kabupaten_kota'   => $this->request->getPost('kabupaten_kota'),
            'provinsi'         => $this->request->getPost('provinsi'),
            'periode_awal'     => $this->request->getPost('periode_awal'),
            'periode_akhir'    => $this->request->getPost('periode_akhir'),
            'nama_kepala_sppg' => $this->request->getPost('nama_kepala_sppg'),
            'nama_akuntan'     => $this->request->getPost('nama_akuntan'),
        ]);

        $this->itemModel->where('stok_opname_id', $id)->delete();

        foreach ($days as $dayNum => $items) {
            if (!is_array($items)) {
                continue;
            }
            foreach ($items as $item) {
                if (empty($item['nama_bahan'])) {
                    continue;
                }
                $this->itemModel->insert([
                    'stok_opname_id' => $id,
                    'hari_ke'        => $dayNum,
                    'nama_bahan'     => $item['nama_bahan'],
                    'satuan'         => $item['satuan'] ?? '',
                    'stok_fisik'     => $item['stok_fisik'] ?? '',
                    'stok_di_kartu'  => $item['stok_di_kartu'] ?? '',
                    'selisih'        => $item['selisih'] ?? '',
                    'keterangan'     => $item['keterangan'] ?? '',
                ]);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memperbarui.')->withInput();
        }

        return redirect()->to('/stok-opname/show/' . $id)->with('success', 'Stok Opname berhasil diperbarui.');
    }

    public function exportPdf($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $allItems = $this->itemModel->where('stok_opname_id', $id)->orderBy('hari_ke', 'ASC')->findAll();
        $grouped = [];
        foreach ($allItems as $item) {
            $grouped[$item['hari_ke']][] = $item;
        }

        $data['header'] = $header;
        $data['grouped_items'] = $grouped;
        $data['title'] = 'Cetak Stok Opname';
        $data['signature'] = signature_row_for_pdf(isset($header['created_by']) ? (int) $header['created_by'] : null);

        return view('stok_opname/print', $data);
    }

    public function exportExcel($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $allItems = $this->itemModel->where('stok_opname_id', $id)->orderBy('hari_ke', 'ASC')->findAll();

        $filename = 'Stok_Opname_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($output, ['LAPORAN BIAYA OPERASIONAL - STOK OPNAME']);
        fputcsv($output, ['SPPG', $header['nama_sppg']]);
        fputcsv($output, ['Periode', $header['periode_awal'] . ' s.d ' . $header['periode_akhir']]);
        fputcsv($output, []);

        $currentDay = 0;
        foreach ($allItems as $i => $item) {
            if ($item['hari_ke'] != $currentDay) {
                $currentDay = $item['hari_ke'];
                fputcsv($output, []);
                fputcsv($output, ['HARI KE-' . $currentDay]);
                fputcsv($output, ['No', 'Nama Bahan', 'Satuan', 'Stok Fisik', 'Stok di Kartu', 'Selisih', 'Keterangan']);
            }
            fputcsv($output, [
                $i + 1, $item['nama_bahan'], $item['satuan'],
                $item['stok_fisik'], $item['stok_di_kartu'], $item['selisih'], $item['keterangan'],
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
        $this->itemModel->where('stok_opname_id', $id)->delete();
        $this->headerModel->delete($id);
        $db->transComplete();

        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal menghapus data.');
        return redirect()->to('/stok-opname')->with('success', 'Data berhasil dihapus.');
    }
}
