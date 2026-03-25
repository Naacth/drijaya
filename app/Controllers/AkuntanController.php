<?php

namespace App\Controllers;

use App\Models\ReportModel;
use App\Models\PurchaseOrderModel;

class AkuntanController extends BaseController
{
    protected $reportModel;
    protected $poModel;

    public function __construct()
    {
        $this->reportModel = new ReportModel();
        $this->poModel     = new PurchaseOrderModel();
    }

    /**
     * Upload report form (laporan keuangan / pemasukan-pengeluaran)
     */
    public function uploadForm($kategori)
    {
        $labels = [
            'laporan_keuangan'     => 'Laporan Keuangan',
            'pemasukan_pengeluaran' => 'Laporan Pemasukan & Pengeluaran',
        ];

        if (! isset($labels[$kategori])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $userId  = session()->get('user_id');
        $reports = $this->reportModel->where(['user_id' => $userId, 'kategori' => $kategori])
                                     ->orderBy('created_at', 'DESC')
                                     ->findAll();

        $data = [
            'title'    => $labels[$kategori],
            'kategori' => $kategori,
            'label'    => $labels[$kategori],
            'reports'  => $reports,
        ];

        return view('reports/upload', $data);
    }

    /**
     * Handle report upload
     */
    public function upload()
    {
        $kategori = $this->request->getPost('kategori');
        $labels = [
            'laporan_keuangan'      => 'Laporan Keuangan',
            'pemasukan_pengeluaran' => 'Laporan Pemasukan & Pengeluaran',
        ];

        if (! isset($labels[$kategori])) {
            return redirect()->back()->with('error', 'Kategori tidak valid.');
        }

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
            'judul'     => $this->request->getPost('judul') ?: $labels[$kategori],
            'kategori'  => $kategori,
            'file_name' => $file->getClientName(),
            'file_path' => 'reports/' . $newName,
            'file_type' => $file->getClientExtension(),
            'file_size' => $file->getSize(),
            'catatan'   => $this->request->getPost('catatan'),
            'status'    => 'pending',
        ]);

        return redirect()->to("/akuntan/upload/{$kategori}")->with('success', 'Laporan berhasil dikirim.');
    }

    /**
     * PO list
     */
    public function orders()
    {
        $userId = session()->get('user_id');

        $data = [
            'title'  => 'Purchase Order',
            'orders' => $this->poModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('po/index_akuntan', $data);
    }

    /**
     * Create PO form
     */
    public function createPO()
    {
        return view('po/create', ['title' => 'Buat Purchase Order Baru']);
    }

    /**
     * Store new PO
     */
    public function storePO()
    {
        $file    = $this->request->getFile('file');
        $poData  = [
            'user_id'    => session()->get('user_id'),
            'nomor_po'   => $this->request->getPost('nomor_po'),
            'vendor'     => $this->request->getPost('vendor'),
            'total'      => $this->request->getPost('total'),
            'status'     => 'diajukan',
            'keterangan' => $this->request->getPost('keterangan'),
        ];

        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/po', $newName);
            $poData['file_name'] = $file->getClientName();
            $poData['file_path'] = 'po/' . $newName;
        }

        $this->poModel->insert($poData);

        return redirect()->to('/akuntan/po')->with('success', 'Purchase Order berhasil dibuat.');
    }
}
