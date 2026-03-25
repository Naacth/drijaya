<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class RelawanController extends BaseController
{
    protected $relawanModel;
    protected $divisions = ['cuci ompreng', 'cooking', 'persiapan', 'security', 'akuntan', 'ahligizi', 'supir', 'packing'];

    public function __construct()
    {
        $this->relawanModel = new \App\Models\RelawanModel();
    }

    public function index()
    {
        $sppgId = session()->get('sppg_id');
        $builder = $this->relawanModel->orderBy('divisi', 'ASC');
        
        if ($sppgId) {
            $builder->where('sppg_id', $sppgId);
        }

        $data = [
            'title'    => 'Managemen Relawan',
            'relawan'  => $builder->findAll(),
            'divisions'=> $this->divisions
        ];

        return view('relawan/index', $data);
    }

    public function create()
    {
        $data = [
            'title'     => 'Tambah Relawan Baru',
            'divisions' => $this->divisions
        ];
        return view('relawan/create', $data);
    }

    public function store()
    {
        $sppgId = session()->get('sppg_id');
        
        $this->relawanModel->save([
            'nama'    => $this->request->getPost('nama'),
            'divisi'  => $this->request->getPost('divisi'),
            'sppg_id' => $sppgId,
        ]);

        return redirect()->to('/relawan')->with('success', 'Relawan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $sppgId = session()->get('user_id'); // Wait, check tenant
        $sppgId = session()->get('sppg_id');
        
        $relawan = $this->relawanModel->where(['id' => $id, 'sppg_id' => $sppgId])->first();
        if (!$relawan) return redirect()->to('/relawan')->with('error', 'Relawan tidak ditemukan');

        $data = [
            'title'     => 'Edit Relawan',
            'relawan'   => $relawan,
            'divisions' => $this->divisions
        ];
        return view('relawan/edit', $data);
    }

    public function update($id)
    {
        $sppgId = session()->get('sppg_id');
        $relawan = $this->relawanModel->where(['id' => $id, 'sppg_id' => $sppgId])->first();
        if (!$relawan) return redirect()->to('/relawan')->with('error', 'Relawan tidak ditemukan');

        $this->relawanModel->update($id, [
            'nama'   => $this->request->getPost('nama'),
            'divisi' => $this->request->getPost('divisi'),
        ]);

        return redirect()->to('/relawan')->with('success', 'Data relawan diperbarui');
    }

    public function delete($id)
    {
        $sppgId = session()->get('sppg_id');
        $this->relawanModel->where(['id' => $id, 'sppg_id' => $sppgId])->delete();
        return redirect()->to('/relawan')->with('success', 'Relawan dihapus');
    }
}
