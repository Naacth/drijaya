<?php

namespace App\Controllers;

use App\Models\ReportModel;
use App\Models\PurchaseOrderModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $role = session()->get('role');

        switch ($role) {
            case 'admin':
                return $this->adminDashboard();
            case 'pic':
                return $this->picDashboard();
            case 'aslap':
                return $this->aslapDashboard();
            case 'akuntan':
                return $this->akuntanDashboard();
            case 'ahli_gizi':
                return $this->ahliGiziDashboard();
            default:
                return redirect()->to('/login');
        }
    }

    private function adminDashboard()
    {
        $reportModel = new ReportModel();
        $userModel   = new UserModel();
        $sppgModel   = new \App\Models\SppgModel();

        $currentSppgId = session()->get('sppg_id');

        $reportBuilder = $reportModel->select('reports.*')
                                     ->join('users', 'users.id = reports.user_id');
        
        $userBuilder   = $userModel;

        if ($currentSppgId) {
            $reportBuilder->where('users.sppg_id', $currentSppgId);
            $userBuilder->where('sppg_id', $currentSppgId);
        }

        // Pending PIC Submissions
        $db = \Config\Database::connect();
        $pendingBarangRusak = [];
        if ($db->tableExists('pengajuan_barang_rusak')) {
            $builder = $db->table('pengajuan_barang_rusak')
                ->select('pengajuan_barang_rusak.*, users.nama as user_nama')
                ->join('users', 'users.id = pengajuan_barang_rusak.created_by')
                ->where('pengajuan_barang_rusak.status', 'diajukan');
            if ($currentSppgId) $builder->where('users.sppg_id', $currentSppgId);
            $pendingBarangRusak = $builder->get()->getResultArray();
        }

        $pendingPengadaan = [];
        if ($db->tableExists('pengadaan_barang')) {
            $builder = $db->table('pengadaan_barang')
                ->select('pengadaan_barang.*, users.nama as user_nama')
                ->join('users', 'users.id = pengadaan_barang.created_by')
                ->where('pengadaan_barang.status', 'diajukan');
            if ($currentSppgId) $builder->where('users.sppg_id', $currentSppgId);
            $pendingPengadaan = $builder->get()->getResultArray();
        }

        $data = [
            'title'              => 'Dashboard Admin',
            'totalReports'       => (clone $reportBuilder)->countAllResults(),
            'pendingReports'     => (clone $reportBuilder)->where('reports.status', 'pending')->countAllResults(),
            'acceptedReports'    => (clone $reportBuilder)->where('reports.status', 'diterima')->countAllResults(),
            'rejectedReports'    => (clone $reportBuilder)->where('reports.status', 'ditolak')->countAllResults(),
            'totalUsers'         => $userBuilder->countAllResults(),
            'recentReports'      => $reportModel->getWithUser($currentSppgId)->limit(10)->findAll(),
            'pendingBarangRusak' => $pendingBarangRusak,
            'pendingPengadaan'   => $pendingPengadaan,
            'allSppg'            => $sppgModel->findAll(),
            'currentSppgId'      => $currentSppgId
        ];

        return view('dashboard/admin', $data);
    }

    public function switchSppg($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back();
        }

        $sppgModel = new \App\Models\SppgModel();
        $sppg = $sppgModel->find($id);

        if ($sppg) {
            session()->set('sppg_id', $sppg['id']);
            session()->set('sppg_nama', $sppg['nama_sppg']);
        } else {
            session()->set('sppg_id', null);
            session()->set('sppg_nama', 'Semua Dapur');
        }

        return redirect()->to('/dashboard')->with('success', 'Berhasil beralih ke ' . ($sppg['nama_sppg'] ?? 'Pusat'));
    }

    private function picDashboard()
    {
        $poModel = new PurchaseOrderModel();
        $sppgId  = session()->get('sppg_id');

        // Count PIC-specific modules
        $db = \Config\Database::connect();
        
        $barangRusakCount = 0;
        $pengadaanCount = 0;
        if ($db->tableExists('pengajuan_barang_rusak')) {
            $barangRusakCount = $db->table('pengajuan_barang_rusak')
                ->join('users', 'users.id = pengajuan_barang_rusak.created_by')
                ->where('users.sppg_id', $sppgId)
                ->countAllResults();
        }
        if ($db->tableExists('pengadaan_barang')) {
            $pengadaanCount = $db->table('pengadaan_barang')
                ->join('users', 'users.id = pengadaan_barang.created_by')
                ->where('users.sppg_id', $sppgId)
                ->countAllResults();
        }

        $totalPO = $poModel->join('users', 'users.id = purchase_orders.user_id')
                           ->where('users.sppg_id', $sppgId)
                           ->countAllResults();

        $menus = [
            'Purchase Order'           => ['route' => 'po', 'icon' => 'bi-receipt-cutoff', 'color' => '#6366f1'],
            'Pengajuan Barang Rusak'   => ['route' => 'pengajuan-barang-rusak', 'icon' => 'bi-tools', 'color' => '#ef4444'],
            'Pengadaan Barang'         => ['route' => 'pengadaan-barang', 'icon' => 'bi-cart-plus', 'color' => '#10b981'],
            'Uji Cita Rasa'            => ['route' => 'uji-cita-rasa', 'icon' => 'bi-palette', 'color' => '#f59e0b'],
            'Pemeriksaan Sampel'       => ['route' => 'pemeriksaan-sampel', 'icon' => 'bi-search', 'color' => '#06b6d4'],
            'Monitoring Suhu Masak'    => ['route' => 'monitoring-suhu-masak', 'icon' => 'bi-thermometer-high', 'color' => '#8b5cf6'],
            'Sanitasi Ruangan'         => ['route' => 'sanitasi-ruangan', 'icon' => 'bi-door-closed', 'color' => '#14b8a6'],
            'Pembersihan Transportasi' => ['route' => 'pembersihan-transportasi', 'icon' => 'bi-truck-flatbed', 'color' => '#0ea5e9'],
            'Higiene Personil'         => ['route' => 'higiene-personil', 'icon' => 'bi-person-check', 'color' => '#f97316'],
            'Alamat SPPG'              => ['route' => 'pic/settings', 'icon' => 'bi-geo-alt-fill', 'color' => '#64748b'],
        ];

        $data = [
            'title'  => 'Dashboard PIC',
            'totalPO' => $totalPO,
            'barangRusakCount' => $barangRusakCount,
            'pengadaanCount' => $pengadaanCount,
            'menus' => $menus,
            'sppg_name' => session()->get('sppg_nama') ?? 'Dapur SPPG',
        ];

        return view('dashboard/pic', $data);
    }

    private function aslapDashboard()
    {
        $userId = session()->get('user_id');
        
        // Models - filter by created_by to show only user's own data
        $models = [
            'barang_datang'       => new \App\Models\BarangDatangModel(),
            'cek_bahan'           => new \App\Models\CekBahanBakuModel(),
            'uji_organoleptik'    => new \App\Models\UjiOrganoleptikModel(),
            'ba_kehilangan'       => new \App\Models\BaKehilanganModel(),
            'pemberitahuan_kerja' => new \App\Models\PemberitahuanKerjaModel(),
            'stok_gudang'         => new \App\Models\StokGudangModel(),
            'stok_opname'         => new \App\Models\StokOpnameModel(),
            'rekap_porsi'         => new \App\Models\RekapPorsiModel(),
        ];

        $stats = [];
        foreach ($models as $key => $model) {
            $stats[$key] = $model->where('created_by', $userId)->countAllResults();
        }

        // Quick Access Menu
        $menus = [
            'Absensi Relawan'       => ['route' => 'absensi', 'icon' => 'bi-calendar-check', 'color' => '#6366f1'],
            'Barang Datang'         => ['route' => 'barang-datang', 'icon' => 'bi-box-seam', 'color' => '#06b6d4'],
            'Cek Bahan Baku'        => ['route' => 'cek-bahan-baku', 'icon' => 'bi-clipboard-check', 'color' => '#10b981'],
            'Uji Organoleptik'      => ['route' => 'uji-organoleptik', 'icon' => 'bi-eyedropper', 'color' => '#f59e0b'],
            'BA Kehilangan'         => ['route' => 'ba-kehilangan', 'icon' => 'bi-exclamation-triangle', 'color' => '#ef4444'],
            'Pemberitahuan Kerja'   => ['route' => 'pemberitahuan-kerja', 'icon' => 'bi-megaphone', 'color' => '#8b5cf6'],
            'Stok di Gudang'        => ['route' => 'stok-gudang', 'icon' => 'bi-building', 'color' => '#0ea5e9'],
            'Stok Opname'           => ['route' => 'stok-opname', 'icon' => 'bi-calculator', 'color' => '#14b8a6'],
            'Rekap Porsi'           => ['route' => 'rekap-porsi', 'icon' => 'bi-pie-chart', 'color' => '#f97316'],
            'Data Relawan'          => ['route' => 'relawan', 'icon' => 'bi-people', 'color' => '#64748b'],
        ];

        $data = [
            'title' => 'Dashboard Asisten Lapangan',
            'stats' => $stats,
            'menus' => $menus,
            'sppg_name' => session()->get('sppg_nama') ?? 'Dapur SPPG',
        ];

        return view('dashboard/aslap', $data);
    }

    private function akuntanDashboard()
    {
        $reportModel = new ReportModel();
        $poModel     = new PurchaseOrderModel();
        $userId      = session()->get('user_id');

        $data = [
            'title'          => 'Dashboard Akuntan',
            'reports'        => $reportModel->getByUser($userId),
            'totalReports'   => $reportModel->where('user_id', $userId)->countAllResults(),
            'pendingReports' => $reportModel->where(['user_id' => $userId, 'status' => 'pending'])->countAllResults(),
            'orders'         => $poModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll(),
            'totalPO'        => $poModel->where('user_id', $userId)->countAllResults(),
            'sppg_name'      => session()->get('sppg_nama') ?? 'Dapur SPPG',
        ];

        return view('dashboard/akuntan', $data);
    }

    private function ahliGiziDashboard()
    {
        $reportModel = new ReportModel();
        $userId = session()->get('user_id');

        $data = [
            'title'          => 'Dashboard Ahli Gizi',
            'reports'        => $reportModel->where(['user_id' => $userId, 'kategori' => 'menu_makanan'])->orderBy('created_at', 'DESC')->findAll(),
            'totalMenu'      => $reportModel->where(['user_id' => $userId, 'kategori' => 'menu_makanan'])->countAllResults(),
            'pendingMenu'    => $reportModel->where(['user_id' => $userId, 'kategori' => 'menu_makanan', 'status' => 'pending'])->countAllResults(),
            'sppg_name'      => session()->get('sppg_nama') ?? 'Dapur SPPG',
        ];

        return view('dashboard/ahli_gizi', $data);
    }
}
