<?php

namespace App\Controllers;

use App\Models\ReportModel;
use App\Models\UserModel;

class AdminController extends BaseController
{
    protected $reportModel;
    protected $userModel;

    public function __construct()
    {
        $this->reportModel = new ReportModel();
        $this->userModel   = new UserModel();
    }

    public function reports()
    {
        $status   = $this->request->getGet('status');
        $kategori = $this->request->getGet('kategori');

        $builder = $this->reportModel->getWithUser();

        if ($status) {
            $builder->where('reports.status', $status);
        }
        if ($kategori) {
            $builder->where('reports.kategori', $kategori);
        }

        $data = [
            'title'   => 'Semua Laporan',
            'reports' => $builder->findAll(),
            'status'  => $status,
            'kategori'=> $kategori,
        ];

        return view('reports/index', $data);
    }

    public function reportDetail($id)
    {
        $report = $this->reportModel->getWithUser()->where('reports.id', $id)->first();

        if (! $report) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('reports/detail', ['title' => 'Detail Laporan', 'report' => $report]);
    }

    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');

        if (! in_array($status, ['diterima', 'ditolak'])) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $this->reportModel->update($id, ['status' => $status]);

        return redirect()->back()->with('success', 'Status laporan berhasil diupdate.');
    }

    public function download($id)
    {
        $report = $this->reportModel->find($id);

        if (! $report || ! file_exists(WRITEPATH . 'uploads/' . $report['file_path'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response->download(WRITEPATH . 'uploads/' . $report['file_path'], null)->setFileName($report['file_name']);
    }

    public function users()
    {
        $sppgId = session()->get('sppg_id');
        $builder = $this->userModel->orderBy('id', 'ASC');

        if (! empty($sppgId)) {
            $builder->where('sppg_id', $sppgId);
        }

        return view('admin/users_index', [
            'title' => 'Manajemen User',
            'users' => $builder->findAll(),
        ]);
    }

    public function editUser($id)
    {
        $sppgId = session()->get('sppg_id');
        $user = $this->userModel->find((int) $id);

        if (! $user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan.');
        }

        if (! empty($sppgId) && (int) ($user['sppg_id'] ?? 0) !== (int) $sppgId) {
            return redirect()->to('/admin/users')->with('error', 'Anda tidak memiliki akses ke user ini.');
        }

        return view('admin/users_edit', [
            'title' => 'Edit User',
            'user'  => $user,
        ]);
    }

    public function updateUser($id)
    {
        $sppgId = session()->get('sppg_id');
        $user = $this->userModel->find((int) $id);

        if (! $user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan.');
        }

        if (! empty($sppgId) && (int) ($user['sppg_id'] ?? 0) !== (int) $sppgId) {
            return redirect()->to('/admin/users')->with('error', 'Anda tidak memiliki akses ke user ini.');
        }

        $rules = [
            'nama' => 'required|min_length[3]',
            'password' => 'permit_empty|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $payload = [
            'nama' => trim((string) $this->request->getPost('nama')),
        ];

        $password = (string) $this->request->getPost('password');
        if ($password !== '') {
            $payload['password'] = $password;
        }

        $this->userModel->update((int) $id, $payload);

        return redirect()->to('/admin/users')->with('success', 'Data user berhasil diperbarui.');
    }
}
