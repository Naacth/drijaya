<?php

namespace App\Controllers;

use App\Models\ReportModel;

class AhliGiziController extends BaseController
{
    protected $reportModel;

    public function __construct()
    {
        $this->reportModel = new ReportModel();
    }

    public function uploadForm()
    {
        $userId  = session()->get('user_id');
        $reports = $this->reportModel->where(['user_id' => $userId, 'kategori' => 'menu_makanan'])
                                     ->orderBy('created_at', 'DESC')
                                     ->findAll();

        $data = [
            'title'    => 'Menu Makanan Harian',
            'kategori' => 'menu_makanan',
            'label'    => 'Menu Makanan Harian',
            'reports'  => $reports,
        ];

        return view('reports/upload', $data);
    }

    public function upload()
    {
        $file = $this->request->getFile('file');

        if (! $file || ! $file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid.');
        }

        $allowedTypes = ['application/pdf', 'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

        if (! in_array($file->getMimeType(), $allowedTypes)) {
            return redirect()->back()->with('error', 'Format file tidak didukung.');
        }

        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/reports', $newName);

        $this->reportModel->insert([
            'user_id'   => session()->get('user_id'),
            'judul'     => $this->request->getPost('judul') ?: 'Menu Makanan Harian',
            'kategori'  => 'menu_makanan',
            'file_name' => $file->getClientName(),
            'file_path' => 'reports/' . $newName,
            'file_type' => $file->getClientExtension(),
            'file_size' => $file->getSize(),
            'catatan'   => $this->request->getPost('catatan'),
            'status'    => 'pending',
        ]);

        return redirect()->to('/ahli-gizi/upload')->with('success', 'Menu makanan berhasil dikirim.');
    }
}
