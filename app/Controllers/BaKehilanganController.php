<?php

namespace App\Controllers;

use App\Models\BaKehilanganModel;
use App\Traits\ChecksAslapOwnsRecord;

class BaKehilanganController extends BaseController
{
    use ChecksAslapOwnsRecord;

    protected $model;

    public function __construct()
    {
        $this->model = new BaKehilanganModel();
    }

    public function index()
    {
        $role   = session()->get('role');
        $userId = session()->get('user_id');

        $db      = \Config\Database::connect();
        $builder = $db->table('ba_kehilangan');
        $builder->select('ba_kehilangan.*, users.nama as user_nama');
        $builder->join('users', 'users.id = ba_kehilangan.created_by');

        if ($role == 'aslap') {
            $builder->where('ba_kehilangan.created_by', $userId);
        } elseif ($role == 'admin' || $role == 'pic') {
            $currentSppgId = session()->get('sppg_id');
            if ($currentSppgId) {
                $builder->where('users.sppg_id', $currentSppgId);
            }
        }

        $builder->orderBy('ba_kehilangan.created_at', 'DESC');

        $data['title'] = 'BA Kehilangan Ompreng';
        $data['forms'] = $builder->get()->getResultArray();

        return view('ba_kehilangan/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Buat Berita Acara Kehilangan Ompreng';
        return view('ba_kehilangan/create', $data);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $insertData = [
            'no_surat'              => $this->request->getPost('no_surat'),
            'nama_sekolah'          => $this->request->getPost('nama_sekolah'),
            'nama_pj_sekolah'       => $this->request->getPost('nama_pj_sekolah'),
            'jam_kehilangan'        => $this->request->getPost('jam_kehilangan'),
            'jam_distribusi'        => $this->request->getPost('jam_distribusi'),
            'tanggal_kejadian'      => $this->request->getPost('tanggal_kejadian'),
            'jumlah_ompreng_hilang' => $this->request->getPost('jumlah_ompreng_hilang'),
            'jumlah_awal'           => $this->request->getPost('jumlah_awal'),
            'jumlah_akhir'          => $this->request->getPost('jumlah_akhir'),
            'nama_supir'            => $this->request->getPost('nama_supir'),
            'created_by'            => session()->get('user_id'),
        ];

        // Handle TTD Supir upload
        $ttdSupir = $this->request->getFile('ttd_supir');
        if ($ttdSupir && $ttdSupir->isValid() && !$ttdSupir->hasMoved()) {
            $newName = 'ttd_supir_' . time() . '.' . $ttdSupir->getExtension();
            $ttdSupir->move('uploads/ba_kehilangan', $newName);
            $insertData['ttd_supir'] = 'uploads/ba_kehilangan/' . $newName;
        }

        // Handle TTD PJ Sekolah upload
        $ttdPj = $this->request->getFile('ttd_pj_sekolah');
        if ($ttdPj && $ttdPj->isValid() && !$ttdPj->hasMoved()) {
            $newName = 'ttd_pj_' . time() . '.' . $ttdPj->getExtension();
            $ttdPj->move('uploads/ba_kehilangan', $newName);
            $insertData['ttd_pj_sekolah'] = 'uploads/ba_kehilangan/' . $newName;
        }

        $this->model->insert($insertData);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan Berita Acara.')->withInput();
        }

        return redirect()->to('/ba-kehilangan')->with('success', 'Berita Acara Kehilangan Ompreng berhasil disimpan.');
    }

    public function show($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('ba_kehilangan');
        $builder->select('ba_kehilangan.*, users.nama as user_nama');
        $builder->join('users', 'users.id = ba_kehilangan.created_by');
        $builder->where('ba_kehilangan.id', $id);
        $header = $builder->get()->getRowArray();

        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if ($r = $this->redirectIfAslapCannotAccessRecord($header, '/ba-kehilangan')) {
            return $r;
        }

        $data['header'] = $header;
        $data['title']  = 'Detail BA Kehilangan Ompreng';

        return view('ba_kehilangan/show', $data);
    }

    public function edit($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('ba_kehilangan');
        $builder->select('ba_kehilangan.*, users.nama as user_nama');
        $builder->join('users', 'users.id = ba_kehilangan.created_by');
        $builder->where('ba_kehilangan.id', $id);
        $header = $builder->get()->getRowArray();

        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if ($r = $this->redirectIfAslapCannotAccessRecord($header, '/ba-kehilangan')) {
            return $r;
        }

        $data['header'] = $header;
        $data['title']  = 'Ubah BA Kehilangan Ompreng';

        return view('ba_kehilangan/edit', $data);
    }

    public function update($id)
    {
        $row = $this->model->find($id);
        if (!$row) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if ($r = $this->redirectIfAslapCannotAccessRecord($row, '/ba-kehilangan')) {
            return $r;
        }

        $updateData = [
            'no_surat'              => $this->request->getPost('no_surat'),
            'nama_sekolah'          => $this->request->getPost('nama_sekolah'),
            'nama_pj_sekolah'       => $this->request->getPost('nama_pj_sekolah'),
            'jam_kehilangan'        => $this->request->getPost('jam_kehilangan'),
            'jam_distribusi'        => $this->request->getPost('jam_distribusi'),
            'tanggal_kejadian'      => $this->request->getPost('tanggal_kejadian'),
            'jumlah_ompreng_hilang' => $this->request->getPost('jumlah_ompreng_hilang'),
            'jumlah_awal'           => $this->request->getPost('jumlah_awal'),
            'jumlah_akhir'          => $this->request->getPost('jumlah_akhir'),
            'nama_supir'            => $this->request->getPost('nama_supir'),
        ];

        $base = rtrim(FCPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        $ttdSupir = $this->request->getFile('ttd_supir');
        if ($ttdSupir && $ttdSupir->isValid() && !$ttdSupir->hasMoved()) {
            if (!empty($row['ttd_supir']) && is_file($base . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $row['ttd_supir']))) {
                @unlink($base . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $row['ttd_supir']));
            }
            $newName = 'ttd_supir_' . time() . '.' . $ttdSupir->getExtension();
            $ttdSupir->move('uploads/ba_kehilangan', $newName);
            $updateData['ttd_supir'] = 'uploads/ba_kehilangan/' . $newName;
        }

        $ttdPj = $this->request->getFile('ttd_pj_sekolah');
        if ($ttdPj && $ttdPj->isValid() && !$ttdPj->hasMoved()) {
            if (!empty($row['ttd_pj_sekolah']) && is_file($base . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $row['ttd_pj_sekolah']))) {
                @unlink($base . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $row['ttd_pj_sekolah']));
            }
            $newName = 'ttd_pj_' . time() . '.' . $ttdPj->getExtension();
            $ttdPj->move('uploads/ba_kehilangan', $newName);
            $updateData['ttd_pj_sekolah'] = 'uploads/ba_kehilangan/' . $newName;
        }

        $this->model->update($id, $updateData);

        return redirect()->to('/ba-kehilangan/show/' . $id)->with('success', 'Berita Acara berhasil diperbarui.');
    }

    public function exportPdf($id)
    {
        $header = $this->model->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data['header'] = $header;
        $data['title']  = 'Cetak BA Kehilangan Ompreng';

        return view('ba_kehilangan/print', $data);
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }

        $this->model->delete($id);
        return redirect()->to('/ba-kehilangan')->with('success', 'Berita Acara Kehilangan berhasil dihapus.');
    }
}
