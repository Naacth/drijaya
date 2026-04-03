<?php

namespace App\Controllers;

use App\Models\PemberitahuanKerjaModel;
use App\Traits\ChecksAslapOwnsRecord;

class PemberitahuanKerjaController extends BaseController
{
    use ChecksAslapOwnsRecord;

    protected $model;

    public function __construct()
    {
        $this->model = new PemberitahuanKerjaModel();
    }

    public function index()
    {
        $role   = session()->get('role');
        $userId = session()->get('user_id');

        $db      = \Config\Database::connect();
        $builder = $db->table('pemberitahuan_kerja');
        $builder->select('pemberitahuan_kerja.*, users.nama as user_nama');
        $builder->join('users', 'users.id = pemberitahuan_kerja.created_by');

        if ($role == 'aslap') {
            $builder->where('pemberitahuan_kerja.created_by', $userId);
        } elseif ($role == 'admin' || $role == 'pic') {
            $currentSppgId = session()->get('sppg_id');
            if ($currentSppgId) {
                $builder->where('users.sppg_id', $currentSppgId);
            }
        }

        $builder->orderBy('pemberitahuan_kerja.created_at', 'DESC');

        $data['title'] = 'Form Pemberitahuan Hasil Kerja';
        $data['forms'] = $builder->get()->getResultArray();

        return view('pemberitahuan_kerja/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Buat Form Pemberitahuan Hasil Kerja';
        return view('pemberitahuan_kerja/create', $data);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $insertData = [
            'no_surat'               => $this->request->getPost('no_surat'),
            'tanggal'                => $this->request->getPost('tanggal'),
            'divisi'                 => $this->request->getPost('divisi'),
            'nama_pic'               => $this->request->getPost('nama_pic'),
            'jam_mulai'              => $this->request->getPost('jam_mulai'),
            'jam_selesai'            => $this->request->getPost('jam_selesai'),
            'keterangan_jumlah_item' => $this->request->getPost('keterangan_jumlah_item'),
            'keterangan_dikerjakan'  => $this->request->getPost('keterangan_dikerjakan'),
            'nama_anggota'           => $this->request->getPost('nama_anggota'),
            'nama_pj'                => $this->request->getPost('nama_pj'),
            'created_by'             => session()->get('user_id'),
        ];

        // Upload TTD Anggota
        $ttdAnggota = $this->request->getFile('ttd_anggota');
        if ($ttdAnggota && $ttdAnggota->isValid() && !$ttdAnggota->hasMoved()) {
            $newName = 'ttd_anggota_' . time() . '.' . $ttdAnggota->getExtension();
            $ttdAnggota->move('uploads/pemberitahuan_kerja', $newName);
            $insertData['ttd_anggota'] = 'uploads/pemberitahuan_kerja/' . $newName;
        }

        // Upload TTD PJ
        $ttdPj = $this->request->getFile('ttd_pj');
        if ($ttdPj && $ttdPj->isValid() && !$ttdPj->hasMoved()) {
            $newName = 'ttd_pj_' . time() . '_pj.' . $ttdPj->getExtension();
            $ttdPj->move('uploads/pemberitahuan_kerja', $newName);
            $insertData['ttd_pj'] = 'uploads/pemberitahuan_kerja/' . $newName;
        }

        $this->model->insert($insertData);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan.')->withInput();
        }

        return redirect()->to('/pemberitahuan-kerja')->with('success', 'Form Pemberitahuan berhasil disimpan.');
    }

    public function show($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('pemberitahuan_kerja');
        $builder->select('pemberitahuan_kerja.*, users.nama as user_nama');
        $builder->join('users', 'users.id = pemberitahuan_kerja.created_by');
        $builder->where('pemberitahuan_kerja.id', $id);
        $header = $builder->get()->getRowArray();

        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if ($r = $this->redirectIfAslapCannotAccessRecord($header, '/pemberitahuan-kerja')) {
            return $r;
        }

        $data['header'] = $header;
        $data['title']  = 'Detail Form Pemberitahuan';

        return view('pemberitahuan_kerja/show', $data);
    }

    public function edit($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('pemberitahuan_kerja');
        $builder->select('pemberitahuan_kerja.*, users.nama as user_nama');
        $builder->join('users', 'users.id = pemberitahuan_kerja.created_by');
        $builder->where('pemberitahuan_kerja.id', $id);
        $header = $builder->get()->getRowArray();

        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if ($r = $this->redirectIfAslapCannotAccessRecord($header, '/pemberitahuan-kerja')) {
            return $r;
        }

        $data['header'] = $header;
        $data['title']  = 'Ubah Form Pemberitahuan';

        return view('pemberitahuan_kerja/edit', $data);
    }

    public function update($id)
    {
        $row = $this->model->find($id);
        if (!$row) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if ($r = $this->redirectIfAslapCannotAccessRecord($row, '/pemberitahuan-kerja')) {
            return $r;
        }

        $updateData = [
            'no_surat'               => $this->request->getPost('no_surat'),
            'tanggal'                => $this->request->getPost('tanggal'),
            'divisi'                 => $this->request->getPost('divisi'),
            'nama_pic'               => $this->request->getPost('nama_pic'),
            'jam_mulai'              => $this->request->getPost('jam_mulai'),
            'jam_selesai'            => $this->request->getPost('jam_selesai'),
            'keterangan_jumlah_item' => $this->request->getPost('keterangan_jumlah_item'),
            'keterangan_dikerjakan'  => $this->request->getPost('keterangan_dikerjakan'),
            'nama_anggota'           => $this->request->getPost('nama_anggota'),
            'nama_pj'                => $this->request->getPost('nama_pj'),
        ];

        $base = rtrim(FCPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        $ttdAnggota = $this->request->getFile('ttd_anggota');
        if ($ttdAnggota && $ttdAnggota->isValid() && !$ttdAnggota->hasMoved()) {
            if (!empty($row['ttd_anggota']) && is_file($base . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $row['ttd_anggota']))) {
                @unlink($base . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $row['ttd_anggota']));
            }
            $newName = 'ttd_anggota_' . time() . '.' . $ttdAnggota->getExtension();
            $ttdAnggota->move('uploads/pemberitahuan_kerja', $newName);
            $updateData['ttd_anggota'] = 'uploads/pemberitahuan_kerja/' . $newName;
        }

        $ttdPj = $this->request->getFile('ttd_pj');
        if ($ttdPj && $ttdPj->isValid() && !$ttdPj->hasMoved()) {
            if (!empty($row['ttd_pj']) && is_file($base . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $row['ttd_pj']))) {
                @unlink($base . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $row['ttd_pj']));
            }
            $newName = 'ttd_pj_' . time() . '_pj.' . $ttdPj->getExtension();
            $ttdPj->move('uploads/pemberitahuan_kerja', $newName);
            $updateData['ttd_pj'] = 'uploads/pemberitahuan_kerja/' . $newName;
        }

        $this->model->update($id, $updateData);

        return redirect()->to('/pemberitahuan-kerja/show/' . $id)->with('success', 'Form Pemberitahuan berhasil diperbarui.');
    }

    public function exportPdf($id)
    {
        $header = $this->model->find($id);
        if (!$header) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data['header'] = $header;
        $data['title']  = 'Cetak Form Pemberitahuan';

        return view('pemberitahuan_kerja/print', $data);
    }

    public function exportPdfBlank()
    {
        helper('print');

        return view('pemberitahuan_kerja/print', [
            'blank'  => true,
            'header' => [
                'no_surat'                  => '',
                'tanggal'                   => '',
                'divisi'                    => '',
                'nama_pic'                  => '',
                'jam_mulai'                 => '',
                'jam_selesai'               => '',
                'keterangan_jumlah_item'    => '',
                'keterangan_dikerjakan'     => '',
                'nama_anggota'              => '',
                'ttd_anggota'               => '',
                'nama_pj'                   => '',
                'ttd_pj'                    => '',
                'created_by'                => null,
            ],
            'title'  => 'Form Pemberitahuan Kerja (kosong)',
        ]);
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }

        $this->model->delete($id);
        return redirect()->to('/pemberitahuan-kerja')->with('success', 'Form Pemberitahuan berhasil dihapus.');
    }
}
