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

    private function getOperationalTables()
    {
        return [
            'ba_kehilangan', 'uji_organoleptik', 'uji_cita_rasa', 'stok_opname',
            'pengajuan_barang_rusak', 'pengadaan_barang', 'barang_datang', 'cek_bahan_baku',
            'checklist_masakan', 'analisis_gizi', 'estimasi_anggaran', 'higiene_personil',
            'makanan_lebih', 'monitoring_suhu_masak', 'pembersihan_bak_sampah', 'pembersihan_harian',
            'pembersihan_lantai', 'pembersihan_mingguan', 'pembersihan_transportasi', 'pembersihan_trolly',
            'pembuangan_sampah', 'pemeriksaan_sampel', 'pencucian_bahan', 'pengeluaran_chemical',
            'rekap_porsi', 'sanitasi_ruangan', 'serah_terima_bahan', 'suhu_chiller_freezer',
            'suhu_ruangan', 'thawing_air', 'thawing_chiller', 'purchase_orders', 'absensi'
        ];
    }

    private function adminDashboard()
    {
        $reportModel = new ReportModel();
        $userModel   = new UserModel();
        $sppgModel   = new \App\Models\SppgModel();
        $db          = \Config\Database::connect();

        $currentSppgId = session()->get('sppg_id');
        
        // Modules for cards
        $topModules = [
            'Purchase Order'     => ['table' => 'purchase_orders', 'icon' => 'bi-receipt', 'color' => '#6366f1', 'url' => 'po'],
            'Absensi Relawan'    => ['table' => 'absensi', 'icon' => 'bi-calendar-check', 'color' => '#8b5cf6', 'url' => 'absensi'],
            'Barang Datang'      => ['table' => 'barang_datang', 'icon' => 'bi-box-seam', 'color' => '#06b6d4', 'url' => 'barang-datang'],
            'Uji Organoleptik'   => ['table' => 'uji_organoleptik', 'icon' => 'bi-eyedropper', 'color' => '#f59e0b', 'url' => 'uji-organoleptik'],
            'BA Kehilangan'      => ['table' => 'ba_kehilangan', 'icon' => 'bi-exclamation-triangle', 'color' => '#ef4444', 'url' => 'ba-kehilangan'],
            'Uji Cita Rasa'      => ['table' => 'uji_cita_rasa', 'icon' => 'bi-palette', 'color' => '#14b8a6', 'url' => 'uji-cita-rasa'],
            'Checklist Masakan'  => ['table' => 'checklist_masakan', 'icon' => 'bi-clipboard-check', 'color' => '#ec4899', 'url' => 'checklist-masakan'],
            'Monitoring Suhu'    => ['table' => 'monitoring_suhu_masak', 'icon' => 'bi-thermometer-high', 'color' => '#f97316', 'url' => 'monitoring-suhu-masak'],
            'Stok Opname'        => ['table' => 'stok_opname', 'icon' => 'bi-calculator', 'color' => '#0ea5e9', 'url' => 'stok-opname'],
            'Sanitasi Ruangan'   => ['table' => 'sanitasi_ruangan', 'icon' => 'bi-door-closed', 'color' => '#10b981', 'url' => 'sanitasi-ruangan'],
        ];

        $moduleStats = [];
        foreach ($topModules as $name => $meta) {
            $builder = $db->table($meta['table'])->join('users', 'users.id = ' . $meta['table'] . '.created_by', 'left');
            if ($currentSppgId) $builder->where('users.sppg_id', $currentSppgId);
            if ($meta['table'] == 'purchase_orders') {
                $builder = $db->table('purchase_orders')->join('users', 'users.id = purchase_orders.user_id', 'left');
                if ($currentSppgId) $builder->where('users.sppg_id', $currentSppgId);
            }
            $moduleStats[$name] = array_merge($meta, ['count' => $builder->countAllResults()]);
        }

        // Aggregate All Tables for Kitchen Status (Total Report Count) - Optimized
        $tables = $this->getOperationalTables();
        $sppgs  = $sppgModel->findAll();
        $sppgCounts = array_fill_keys(array_column($sppgs, 'id'), 0);
        
        foreach ($tables as $table) {
            if ($db->tableExists($table)) {
                $joinCol = ($table == 'purchase_orders') ? 'user_id' : 'created_by';
                $counts = $db->table($table)
                             ->select('users.sppg_id, COUNT(*) as qty')
                             ->join('users', 'users.id = ' . $table . '.' . $joinCol)
                             ->groupBy('users.sppg_id')
                             ->get()->getResultArray();
                
                foreach ($counts as $row) {
                    if (isset($sppgCounts[$row['sppg_id']])) {
                        $sppgCounts[$row['sppg_id']] += (int)$row['qty'];
                    }
                }
            }
        }

        $kitchenStatus = [];
        foreach ($sppgs as $sppg) {
            $sppg['report_count'] = $sppgCounts[$sppg['id']] ?? 0;
            $kitchenStatus[] = $sppg;
        }

        // Pending PIC Submissions
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

        $userRoleStats = $userModel->select('role, COUNT(*) as count')->groupBy('role')->findAll();

        $data = [
            'title'              => 'Dashboard Admin',
            'totalUsers'         => $userModel->countAllResults(),
            'pendingBarangRusak' => $pendingBarangRusak,
            'pendingPengadaan'   => $pendingPengadaan,
            'allSppg'            => $sppgs,
            'currentSppgId'      => $currentSppgId,
            'userRoleStats'      => $userRoleStats,
            'moduleStats'        => $moduleStats,
            'kitchenStatus'      => $kitchenStatus,
            'recentReports'      => $reportModel->getWithUser($currentSppgId)->limit(5)->findAll()
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
        $sppgId = session()->get('sppg_id');
        
        $models = [
            'barang_datang'       => ['model' => new \App\Models\BarangDatangModel(), 'table' => 'barang_datang'],
            'cek_bahan'           => ['model' => new \App\Models\CekBahanBakuModel(),  'table' => 'cek_bahan_baku'],
            'uji_organoleptik'    => ['model' => new \App\Models\UjiOrganoleptikModel(), 'table' => 'uji_organoleptik'],
            'ba_kehilangan'       => ['model' => new \App\Models\BaKehilanganModel(), 'table' => 'ba_kehilangan'],
            'pemberitahuan_kerja' => ['model' => new \App\Models\PemberitahuanKerjaModel(), 'table' => 'pemberitahuan_kerja'],
            'stok_gudang'         => ['model' => new \App\Models\StokGudangModel(), 'table' => 'stok_gudang'],
            'stok_opname'         => ['model' => new \App\Models\StokOpnameModel(), 'table' => 'stok_opname'],
            'rekap_porsi'         => ['model' => new \App\Models\RekapPorsiModel(), 'table' => 'rekap_porsi'],
        ];

        $stats = [];
        foreach ($models as $key => $m) {
            $stats[$key] = $m['model']->join('users', 'users.id = ' . $m['table'] . '.created_by')
                                      ->where('users.sppg_id', $sppgId)
                                      ->countAllResults();
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
