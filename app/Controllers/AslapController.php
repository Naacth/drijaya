<?php

namespace App\Controllers;

use App\Models\ReportModel;

class AslapController extends BaseController
{
    protected $reportModel;

    public function __construct()
    {
        $this->reportModel = new ReportModel();
    }

    /**
     * Show upload form for a specific category
     */
    public function uploadForm($kategori)
    {
        $kategoriLabels = $this->getKategoriLabels();

        if (! isset($kategoriLabels[$kategori])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $userId  = session()->get('user_id');
        $reports = $this->reportModel->where(['user_id' => $userId, 'kategori' => $kategori])
                                     ->orderBy('created_at', 'DESC')
                                     ->findAll();

        $data = [
            'title'    => $kategoriLabels[$kategori],
            'kategori' => $kategori,
            'label'    => $kategoriLabels[$kategori],
            'reports'  => $reports,
        ];

        return view('reports/upload', $data);
    }

    /**
     * Handle file upload
     */
    public function upload()
    {
        $kategori = $this->request->getPost('kategori');
        $kategoriLabels = $this->getKategoriLabels();

        if (! isset($kategoriLabels[$kategori])) {
            return redirect()->back()->with('error', 'Kategori tidak valid.');
        }

        $file = $this->request->getFile('file');

        if (! $file || ! $file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid atau belum dipilih.');
        }

        // Validate file type
        $allowedTypes = ['application/pdf', 'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

        if (! in_array($file->getMimeType(), $allowedTypes)) {
            return redirect()->back()->with('error', 'Format file tidak didukung. Gunakan PDF, Word, atau Excel.');
        }

        // Max 10MB
        if ($file->getSize() > 10 * 1024 * 1024) {
            return redirect()->back()->with('error', 'Ukuran file maksimal 10MB.');
        }

        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/reports', $newName);

        $this->reportModel->insert([
            'user_id'   => session()->get('user_id'),
            'judul'     => $this->request->getPost('judul') ?: $kategoriLabels[$kategori],
            'kategori'  => $kategori,
            'file_name' => $file->getClientName(),
            'file_path' => 'reports/' . $newName,
            'file_type' => $file->getClientExtension(),
            'file_size' => $file->getSize(),
            'catatan'   => $this->request->getPost('catatan'),
            'status'    => 'pending',
        ]);

        return redirect()->to("/aslap/upload/{$kategori}")->with('success', 'Laporan berhasil dikirim ke Admin.');
    }

    /**
     * View submission history
     */
    public function history()
    {
        $userId  = session()->get('user_id');
        $reports = $this->reportModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();

        return view('reports/history', [
            'title'   => 'Riwayat Laporan',
            'reports' => $reports,
        ]);
    }

    private function getKategoriLabels(): array
    {
        return [
            'data_siswa'          => 'Data Siswa / Penerima Manfaat',
            'barang_datang'       => 'Formulir Barang Datang',
            'cek_bahan_baku'      => 'Pengecekan Bahan Baku',
            'alergi_siswa'        => 'Data Alergi Siswa',
            'uji_organoleptik'    => 'Uji Organoleptik',
            'ba_kehilangan'       => 'BA Kehilangan Ompreng',
            'pemberitahuan_kerja' => 'Pemberitahuan Hasil Kerja',
            'stok_gudang'         => 'Stok Barang di Gudang',
            'stok_opname'         => 'Stok Opname',
            'data_guru'           => 'Data Guru',
            'data_bahan_baku'     => 'Data Bahan Baku',
            'rekap_porsi'         => 'Rekap Jumlah Porsi',
        ];
    }
}
