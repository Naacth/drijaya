<?php

namespace App\Controllers;

use App\Traits\ChecksAhliGiziOwnership;
use App\Models\ChecklistMasakanModel;
use App\Models\ChecklistMasakanItemModel;

class ChecklistMasakanController extends BaseController
{
    use ChecksAhliGiziOwnership;

    protected $headerModel;
    protected $itemModel;

    public function __construct()
    {
        $this->headerModel = new ChecklistMasakanModel();
        $this->itemModel   = new ChecklistMasakanItemModel();
    }

    public function index()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('checklist_masakan');
        $builder->select('checklist_masakan.*, users.nama as user_nama');
        $builder->join('users', 'users.id = checklist_masakan.created_by');

        $role   = session()->get('role');
        $userId = session()->get('user_id');
        $sppgId = session()->get('sppg_id');

        if ($role == 'ahli_gizi') {
            $builder->where('checklist_masakan.created_by', $userId);
        } elseif ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $builder->where('users.sppg_id', $sppgId);
        }

        $builder->orderBy('checklist_masakan.created_at', 'DESC');
        $data['title'] = 'Checklist Pemeriksaan Hasil Masakan';
        $data['forms'] = $builder->get()->getResultArray();
        return view('checklist_masakan/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Buat Checklist Masakan';
        return view('checklist_masakan/create', $data);
    }

    public function store()
    {
        $items = $this->request->getPost('items');
        if (empty($items)) {
            return redirect()->back()->with('error', 'Minimal harus mengisi 1 baris.')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $headerId = $this->headerModel->insert([
            'tanggal'         => $this->request->getPost('tanggal'),
            'waktu_penyajian' => $this->request->getPost('waktu_penyajian'),
            'sppg_id'         => session()->get('sppg_id'),
            'created_by'      => session()->get('user_id'),
        ]);

        foreach ($items as $item) {
            $this->itemModel->insert([
                'checklist_masakan_id' => $headerId,
                'nama_masakan'         => $item['nama_masakan'],
                'gramasi_standar'      => $item['gramasi_standar'] ?? 0,
                'gramasi_real'         => $item['gramasi_real'] ?? 0,
                'rasa'                 => $item['rasa'] ?? 'Sesuai',
                'tekstur'              => $item['tekstur'] ?? 'Sesuai',
                'keterangan'           => $item['keterangan'] ?? '',
            ]);
        }

        $db->transComplete();
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan data.')->withInput();
        }
        return redirect()->to('/checklist-masakan')->with('success', 'Data Checklist Masakan berhasil disimpan.');
    }

    public function show($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('checklist_masakan');
        $builder->select('checklist_masakan.*, users.nama as user_nama');
        $builder->join('users', 'users.id = checklist_masakan.created_by');
        $builder->where('checklist_masakan.id', $id);
        $header = $builder->get()->getRowArray();
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($header, '/checklist-masakan')) {
            return $r;
        }

        $data['header'] = $header;
        $data['items']  = $this->itemModel->where('checklist_masakan_id', $id)->findAll();
        $data['title']  = 'Detail Checklist Masakan';
        return view('checklist_masakan/show', $data);
    }

    public function edit($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($header, '/checklist-masakan')) {
            return $r;
        }

        $data = [
            'header' => $header,
            'items'  => $this->itemModel->where('checklist_masakan_id', $id)->findAll(),
            'title'  => 'Edit Checklist Masakan'
        ];
        return view('checklist_masakan/edit', $data);
    }

    public function update($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if ($r = $this->redirectIfAhliGiziCannotAccessRecord($header, '/checklist-masakan')) {
            return $r;
        }

        $items = $this->request->getPost('items');
        if (empty($items)) {
            return redirect()->back()->with('error', 'Minimal harus mengisi 1 baris.')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->headerModel->update($id, [
            'tanggal'         => $this->request->getPost('tanggal'),
            'waktu_penyajian' => $this->request->getPost('waktu_penyajian'),
        ]);

        $this->itemModel->where('checklist_masakan_id', $id)->delete();
        foreach ($items as $item) {
            $this->itemModel->insert([
                'checklist_masakan_id' => $id,
                'nama_masakan'         => $item['nama_masakan'],
                'gramasi_standar'      => $item['gramasi_standar'] ?? 0,
                'gramasi_real'         => $item['gramasi_real'] ?? 0,
                'rasa'                 => $item['rasa'] ?? 'Sesuai',
                'tekstur'              => $item['tekstur'] ?? 'Sesuai',
                'keterangan'           => $item['keterangan'] ?? '',
            ]);
        }

        $db->transComplete();
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memperbarui data.')->withInput();
        }
        return redirect()->to('/checklist-masakan')->with('success', 'Data Checklist Masakan berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }

        $db = \Config\Database::connect();
        $db->transStart();
        
        $this->itemModel->where('checklist_masakan_id', $id)->delete();
        $this->headerModel->delete($id);

        $db->transComplete();
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menghapus data.');
        }

        return redirect()->to('/checklist-masakan')->with('success', 'Data Checklist Masakan berhasil dihapus.');
    }

    public function exportPdf($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('checklist_masakan');
        $builder->select('checklist_masakan.*, users.nama as user_nama, users.id as user_id');
        $builder->join('users', 'users.id = checklist_masakan.created_by');
        $builder->where('checklist_masakan.id', $id);
        $header = $builder->get()->getRowArray();

        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data['header']    = $header;
        $data['items']     = $this->itemModel->where('checklist_masakan_id', $id)->findAll();
        $data['title']     = 'Cetak Checklist Masakan';
        return view('checklist_masakan/print', $data);
    }

    public function exportPdfBlank()
    {
        helper('print');
        $items = [];
        for ($i = 0; $i < 12; $i++) {
            $items[] = [
                'nama_masakan'     => '',
                'gramasi_standar'  => '',
                'gramasi_real'     => '',
                'rasa'             => '',
                'tekstur'          => '',
                'keterangan'       => '',
            ];
        }

        return view('checklist_masakan/print', [
            'blank'  => true,
            'header' => [
                'id'                => 0,
                'tanggal'           => '',
                'waktu_penyajian'   => '',
                'user_nama'         => '',
                'created_by'        => null,
            ],
            'items'  => $items,
            'title'  => 'Form Checklist Masakan (kosong)',
        ]);
    }

    public function exportExcel($id)
    {
        $header = $this->headerModel->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $items = $this->itemModel->where('checklist_masakan_id', $id)->findAll();

        $filename = 'Checklist_Masakan_' . date('Ymd') . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        $output = fopen('php://output', 'w');
        fputcsv($output, ['CHECKLIST PEMERIKSAAN HASIL MASAKAN']);
        fputcsv($output, ['Tanggal', $header['tanggal']]);
        fputcsv($output, ['Waktu Penyajian', $header['waktu_penyajian']]);
        fputcsv($output, []);
        fputcsv($output, ['No', 'Nama Masakan', 'Std Gram', 'Real Gram', 'Rasa', 'Tekstur', 'Keterangan']);
        foreach ($items as $i => $item) {
            fputcsv($output, [$i + 1, $item['nama_masakan'], $item['gramasi_standar'], $item['gramasi_real'], $item['rasa'], $item['tekstur'], $item['keterangan']]);
        }
        fclose($output);
        exit;
    }
}
