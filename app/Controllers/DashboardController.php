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

        // Base Query for Reports (join with users to get sppg_id)
        $reportBuilder = $reportModel->select('reports.*')
                                     ->join('users', 'users.id = reports.user_id');
        
        $userBuilder   = $userModel;

        if ($currentSppgId) {
            $reportBuilder->where('users.sppg_id', $currentSppgId);
            $userBuilder->where('sppg_id', $currentSppgId);
        }

        $data = [
            'title'          => 'Dashboard Admin',
            'totalReports'   => (clone $reportBuilder)->countAllResults(),
            'pendingReports' => (clone $reportBuilder)->where('reports.status', 'pending')->countAllResults(),
            'acceptedReports'=> (clone $reportBuilder)->where('reports.status', 'diterima')->countAllResults(),
            'rejectedReports'=> (clone $reportBuilder)->where('reports.status', 'ditolak')->countAllResults(),
            'totalUsers'     => $userBuilder->countAllResults(),
            'recentReports'  => $reportModel->getWithUser($currentSppgId)->limit(10)->findAll(),
            'allSppg'        => $sppgModel->findAll(),
            'currentSppgId'  => $currentSppgId
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

        $data = [
            'title'  => 'Dashboard PIC',
            'orders' => $poModel->getWithUser()->findAll(),
        ];

        return view('dashboard/pic', $data);
    }

    private function aslapDashboard()
    {
        $tenantId = session()->get('sppg_id');
        
        // Models
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
            $stats[$key] = $model->countAllResults();
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
            'title'     => 'Dashboard Akuntan',
            'reports'   => $reportModel->getByUser($userId),
            'orders'    => $poModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll(),
            'totalPO'   => $poModel->where('user_id', $userId)->countAllResults(),
        ];

        return view('dashboard/akuntan', $data);
    }

    private function ahliGiziDashboard()
    {
        $reportModel = new ReportModel();
        $userId = session()->get('user_id');

        $data = [
            'title'   => 'Dashboard Ahli Gizi',
            'reports' => $reportModel->where(['user_id' => $userId, 'kategori' => 'menu_makanan'])->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('dashboard/ahli_gizi', $data);
    }
}
