<?php

namespace App\Controllers;

use App\Models\ReportModel;
use App\Models\UserModel;

class AdminController extends BaseController
{
    protected $reportModel;

    public function __construct()
    {
        $this->reportModel = new ReportModel();
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
}
