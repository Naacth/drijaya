<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'SPPG Management') ?> - SPPG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: linear-gradient(135deg, #6366f1, #8b5cf6);
            --accent-gradient: linear-gradient(135deg, #6366f1, #8b5cf6, #a855f7);
            --card-shadow: 0 4px 24px rgba(0,0,0,0.06);
            --card-hover-shadow: 0 8px 32px rgba(99,102,241,0.15);
            --body-bg: #f1f5f9;
            --text-primary: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--body-bg);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: #fff;
            z-index: 1050;
            transition: transform 0.3s cubic-bezier(.4,0,.2,1);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar-brand-icon {
            width: 42px; height: 42px;
            background: var(--accent-gradient);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
            box-shadow: 0 4px 12px rgba(99,102,241,0.4);
        }

        .sidebar-brand h5 {
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin: 0;
        }

        .sidebar-brand small {
            font-size: 0.7rem;
            color: #94a3b8;
            font-weight: 400;
        }

        .sidebar-nav {
            padding: 1rem 0.75rem;
            flex: 1;
        }

        .sidebar-nav .nav-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #475569;
            padding: 0.75rem 0.75rem 0.35rem;
            font-weight: 600;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0.85rem;
            border-radius: 10px;
            color: #94a3b8;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            margin-bottom: 2px;
        }

        .sidebar-nav .nav-link:hover {
            background: var(--sidebar-hover);
            color: #e2e8f0;
        }

        .sidebar-nav .nav-link.active {
            background: var(--sidebar-active);
            color: #fff;
            box-shadow: 0 4px 12px rgba(99,102,241,0.35);
        }

        .sidebar-nav .nav-link i {
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
        }

        .sidebar-user {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-user-avatar {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #06b6d4, #6366f1);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .sidebar-user-info {
            flex: 1;
            min-width: 0;
        }

        .sidebar-user-info strong {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-info small {
            color: #64748b;
            font-size: 0.7rem;
            text-transform: capitalize;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: 64px;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            z-index: 1040;
        }

        .topbar-title h6 {
            font-size: 1rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-primary);
        }

        .topbar-title small {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-topbar {
            width: 40px; height: 40px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: #fff;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-muted);
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-topbar:hover {
            border-color: #6366f1;
            color: #6366f1;
            box-shadow: 0 2px 8px rgba(99,102,241,0.12);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 88px 1.5rem 2rem;
            min-height: 100vh;
        }

        /* ===== STAT CARDS ===== */
        .stat-card {
            border: none;
            border-radius: 16px;
            background: #fff;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(.4,0,.2,1);
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-hover-shadow);
        }

        .stat-card .card-body {
            padding: 1.25rem;
        }

        .stat-card .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.35rem;
            color: #fff;
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin: 0;
        }

        .stat-card .stat-label {
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* ===== DATA TABLE ===== */
        .data-card {
            border: none;
            border-radius: 16px;
            background: #fff;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .data-card .card-header {
            background: #fff;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .data-card .card-header h6 {
            font-weight: 700;
            font-size: 0.95rem;
            margin: 0;
        }

        .table-premium {
            margin: 0;
        }

        .table-premium thead th {
            background: #f8fafc;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            font-weight: 600;
            border-bottom: 1px solid var(--border-color);
            padding: 0.85rem 1rem;
        }

        .table-premium tbody td {
            padding: 0.85rem 1rem;
            font-size: 0.85rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-premium tbody tr:hover {
            background: #f8fafc;
        }

        /* ===== BADGES ===== */
        .badge-status {
            padding: 0.35em 0.8em;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .badge-pending   { background: #fef3c7; color: #92400e; }
        .badge-diterima  { background: #d1fae5; color: #065f46; }
        .badge-ditolak   { background: #fee2e2; color: #991b1b; }
        .badge-draft     { background: #e2e8f0; color: #475569; }
        .badge-diajukan  { background: #dbeafe; color: #1e40af; }
        .badge-disetujui { background: #d1fae5; color: #065f46; }

        /* ===== CATEGORY GRID ===== */
        .category-card {
            border: none;
            border-radius: 16px;
            background: #fff;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(.4,0,.2,1);
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
            overflow: hidden;
        }

        .category-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--card-hover-shadow);
            color: inherit;
        }

        .category-card .card-body {
            padding: 1.5rem;
            text-align: center;
        }

        .category-icon {
            width: 56px; height: 56px;
            border-radius: 14px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            color: #fff;
            margin-bottom: 0.75rem;
            transition: transform 0.3s;
        }

        .category-card:hover .category-icon {
            transform: scale(1.1);
        }

        .category-card h6 {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .category-card small {
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        /* ===== FORM STYLES ===== */
        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid var(--border-color);
            padding: 0.65rem 1rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        }

        .form-label {
            font-weight: 600;
            font-size: 0.8rem;
            color: var(--text-primary);
            margin-bottom: 0.35rem;
        }

        .btn-primary {
            background: var(--accent-gradient);
            border: none;
            border-radius: 10px;
            padding: 0.65rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(99,102,241,0.3);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(99,102,241,0.4);
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
        }

        .btn-outline-primary {
            border: 1.5px solid #6366f1;
            color: #6366f1;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .btn-outline-primary:hover {
            background: #6366f1;
            border-color: #6366f1;
        }

        /* ===== UPLOAD ZONE ===== */
        .upload-zone {
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            padding: 2.5rem;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            background: #f8fafc;
        }

        .upload-zone:hover, .upload-zone.dragover {
            border-color: #6366f1;
            background: rgba(99,102,241,0.04);
        }

        .upload-zone i {
            font-size: 2.5rem;
            color: #94a3b8;
            margin-bottom: 0.75rem;
        }

        .upload-zone:hover i {
            color: #6366f1;
        }

        /* ===== ALERTS ===== */
        .alert {
            border: none;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* ===== MOBILE TOGGLE ===== */
        .sidebar-toggle {
            display: none;
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 1060;
            width: 52px; height: 52px;
            border-radius: 14px;
            background: var(--accent-gradient);
            border: none;
            color: #fff;
            font-size: 1.25rem;
            box-shadow: 0 4px 16px rgba(99,102,241,0.4);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 1045;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .sidebar-overlay.show {
                display: block;
            }
            .sidebar-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .topbar { left: 0; }
            .main-content { margin-left: 0; }
        }

        /* ===== ANIMATION ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .animate-in {
            animation: fadeInUp 0.4s ease-out both;
        }

        .animate-in:nth-child(1) { animation-delay: 0.05s; }
        .animate-in:nth-child(2) { animation-delay: 0.1s; }
        .animate-in:nth-child(3) { animation-delay: 0.15s; }
        .animate-in:nth-child(4) { animation-delay: 0.2s; }
        .animate-in:nth-child(5) { animation-delay: 0.25s; }
        .animate-in:nth-child(6) { animation-delay: 0.3s; }
    </style>
</head>
<body>
    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="bi bi-grid-1x2-fill"></i>
            </div>
            <div>
                <h5>SPPG</h5>
                <small>Management System</small>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">Menu</div>

            <a href="<?= site_url('dashboard') ?>" class="nav-link <?= uri_string() === 'dashboard' ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <?php $role = session()->get('role'); ?>

            <?php if ($role === 'admin'): ?>
                <div class="nav-label">Administrasi</div>
                <a href="<?= site_url('admin/reports') ?>" class="nav-link <?= str_starts_with(uri_string(), 'admin/reports') ? 'active' : '' ?>">
                    <i class="bi bi-file-earmark-text-fill"></i> Semua Laporan
                </a>
                <a href="<?= base_url('penerima-manfaat') ?>" class="nav-link <?= str_starts_with(uri_string(), 'penerima-manfaat') ? 'active' : '' ?>">
                    <i class="bi bi-people-fill"></i> Penerima Manfaat
                </a>
                <a href="<?= base_url('routes') ?>" class="nav-link <?= str_starts_with(uri_string(), 'routes') ? 'active' : '' ?>">
                    <i class="bi bi-map-fill"></i> Rute Pengiriman
                </a>
                <a href="<?= site_url('buku-kas/report') ?>" class="nav-link <?= str_starts_with(uri_string(), 'buku-kas') ? 'active' : '' ?>">
                    <i class="bi bi-journal-text"></i> Buku Kas Operasional
                </a>
                <a href="<?= site_url('petty-cash/report') ?>" class="nav-link <?= str_starts_with(uri_string(), 'petty-cash') ? 'active' : '' ?>">
                    <i class="bi bi-cash-stack"></i> Laporan Petty Cash
                </a>
            <?php endif; ?>

            <?php if ($role === 'aslap'): ?>
                <div class="nav-label">Formulir Data Entry</div>
                <a href="<?= site_url('barang-datang') ?>" class="nav-link <?= str_starts_with(uri_string(), 'barang-datang') ? 'active' : '' ?>">
                    <i class="bi bi-box-seam-fill"></i> Barang Datang
                </a>
                <a href="<?= site_url('cek-bahan-baku') ?>" class="nav-link <?= str_starts_with(uri_string(), 'cek-bahan-baku') ? 'active' : '' ?>">
                    <i class="bi bi-clipboard-check-fill"></i> Cek Bahan Baku
                </a>
                <a href="<?= site_url('uji-organoleptik') ?>" class="nav-link <?= str_starts_with(uri_string(), 'uji-organoleptik') ? 'active' : '' ?>">
                    <i class="bi bi-eyedropper"></i> Uji Organoleptik
                </a>
                <a href="<?= site_url('ba-kehilangan') ?>" class="nav-link <?= str_starts_with(uri_string(), 'ba-kehilangan') ? 'active' : '' ?>">
                    <i class="bi bi-exclamation-triangle-fill"></i> BA Kehilangan
                </a>
                <a href="<?= site_url('pemberitahuan-kerja') ?>" class="nav-link <?= str_starts_with(uri_string(), 'pemberitahuan-kerja') ? 'active' : '' ?>">
                    <i class="bi bi-megaphone-fill"></i> Hasil Kerja
                </a>
                <a href="<?= site_url('stok-gudang') ?>" class="nav-link <?= str_starts_with(uri_string(), 'stok-gudang') ? 'active' : '' ?>">
                    <i class="bi bi-building-fill"></i> Stok Gudang
                </a>
                <a href="<?= site_url('stok-opname') ?>" class="nav-link <?= str_starts_with(uri_string(), 'stok-opname') ? 'active' : '' ?>">
                    <i class="bi bi-calculator-fill"></i> Stok Opname
                </a>
                <a href="<?= site_url('rekap-porsi') ?>" class="nav-link <?= str_starts_with(uri_string(), 'rekap-porsi') ? 'active' : '' ?>">
                    <i class="bi bi-pie-chart-fill"></i> Rekap Porsi
                </a>

                <div class="nav-label">Ketenagaan & Absensi</div>
                <a href="<?= site_url('absensi/create') ?>" class="nav-link <?= uri_string() === 'absensi/create' ? 'active' : '' ?>">
                    <i class="bi bi-calendar-check-fill"></i> Input Absensi
                </a>
                <a href="<?= site_url('absensi') ?>" class="nav-link <?= (url_is('absensi') || url_is('absensi/show*') || url_is('absensi/rekap*')) ? 'active' : '' ?>">
                    <i class="bi bi-clock-history"></i> Riwayat & Rekap
                </a>
                <a href="<?= site_url('relawan') ?>" class="nav-link <?= str_starts_with(uri_string(), 'relawan') ? 'active' : '' ?>">
                    <i class="bi bi-people-fill"></i> Manage Relawan
                </a>
                
                <div class="nav-label">Upload Laporan Tambahan</div>
                <?php
                $aslapMenus = [
                    'data_siswa'          => ['Data Siswa',             'bi-people-fill'],
                    'alergi_siswa'        => ['Alergi Siswa',           'bi-heart-pulse-fill'],
                    'data_guru'           => ['Data Guru',              'bi-person-badge-fill'],
                    'data_bahan_baku'     => ['Bahan Baku',             'bi-basket3-fill'],
                ];
                foreach ($aslapMenus as $key => $menu): ?>
                <a href="<?= site_url("aslap/upload/{$key}") ?>" class="nav-link <?= uri_string() === "aslap/upload/{$key}" ? 'active' : '' ?>">
                    <i class="bi <?= $menu[1] ?>"></i> <?= $menu[0] ?>
                </a>
                <?php endforeach; ?>
                <div class="nav-label">Data Lapangan</div>
                <a href="<?= base_url('penerima-manfaat') ?>" class="nav-link <?= str_starts_with(uri_string(), 'penerima-manfaat') ? 'active' : '' ?>">
                    <i class="bi bi-people-fill"></i> Penerima Manfaat
                </a>
                <a href="<?= base_url('routes') ?>" class="nav-link <?= str_starts_with(uri_string(), 'routes') ? 'active' : '' ?>">
                    <i class="bi bi-map-fill"></i> Rute Pengiriman
                </a>
                <div class="nav-label">Pengaturan</div>
                <a href="<?= base_url('signatures') ?>" class="nav-link <?= str_starts_with(uri_string(), 'signatures') ? 'active' : '' ?>">
                    <i class="bi bi-pen-fill"></i> Tanda Tangan
                </a>
            <?php endif; ?>

            <?php if ($role === 'akuntan'): ?>
                <div class="nav-label">Keuangan</div>
                <a href="<?= site_url('buku-kas') ?>" class="nav-link <?= str_starts_with(uri_string(), 'buku-kas') ? 'active' : '' ?>">
                    <i class="bi bi-journal-check"></i> Buku Kas Operasional
                </a>
                <a href="<?= site_url('petty-cash') ?>" class="nav-link <?= str_starts_with(uri_string(), 'petty-cash') ? 'active' : '' ?>">
                    <i class="bi bi-wallet2"></i> Laporan Petty Cash
                </a>
                <a href="<?= site_url('akuntan/upload/laporan_keuangan') ?>" class="nav-link <?= uri_string() === 'akuntan/upload/laporan_keuangan' ? 'active' : '' ?>">
                    <i class="bi bi-journal-text"></i> Laporan Keuangan
                </a>
                <a href="<?= site_url('akuntan/upload/pemasukan_pengeluaran') ?>" class="nav-link <?= str_starts_with(uri_string(), 'akuntan/upload/pemasukan_pengeluaran') ? 'active' : '' ?>">
                    <i class="bi bi-cash-stack"></i> Pemasukan & Pengeluaran
                </a>
                <div class="nav-label">Procurement</div>
                <a href="<?= base_url('po') ?>" class="nav-link <?= str_starts_with(uri_string(), 'po') ? 'active' : '' ?>">
                    <i class="bi bi-receipt-cutoff"></i> Purchase Order
                </a>
            <?php endif; ?>

            <?php if ($role === 'ahli_gizi' || $role === 'admin'): ?>
                <div class="nav-label">Manajemen Mutu & Gizi</div>
                <?php
                $mutuMenus = [
                    'uji-cita-rasa'          => ['Uji Cita Rasa', 'bi-palette'],
                    'pemeriksaan-sampel'     => ['Pemeriksaan & Sampel', 'bi-search'],
                    'makanan-lebih'          => ['Penanganan Makanan Lebih', 'bi-trash3'],
                    'serah-terima-bahan'     => ['Serah Terima Bahan', 'bi-truck'],
                    'monitoring-suhu-masak'  => ['Suhu Pemasakan', 'bi-thermometer-high'],
                    'thawing-air'            => ['Thawing (Air)', 'bi-water'],
                    'thawing-chiller'        => ['Thawing (Chiller)', 'bi-snow2'],
                    'suhu-ruangan'           => ['Suhu Ruangan', 'bi-thermometer-half'],
                    'suhu-chiller-freezer'   => ['Suhu Chiller/Freezer', 'bi-thermometer-snow'],
                    'pencucian-bahan'        => ['Pencucian Bahan', 'bi-droplet-half'],
                ];
                foreach ($mutuMenus as $uri => $menu): ?>
                <a href="<?= site_url($uri) ?>" class="nav-link <?= str_starts_with(uri_string(), $uri) ? 'active' : '' ?>">
                    <i class="bi <?= $menu[1] ?>"></i> <?= $menu[0] ?>
                </a>
                <?php endforeach; ?>

                <div class="nav-label">Operasional & Sanitasi</div>
                <?php
                $opsMenus = [
                    'sanitasi-ruangan'       => ['Sanitasi Ruangan', 'bi-door-closed'],
                    'pembersihan-harian'     => ['Pembersihan Harian', 'bi-clock-history'],
                    'pembersihan-mingguan'   => ['Pembersihan Mingguan', 'bi-calendar-check'],
                    'pembuangan-sampah'      => ['Pembuangan Sampah', 'bi-recycle'],
                    'pembersihan-bak-sampah' => ['Pembersihan Bak Sampah', 'bi-bucket'],
                    'pembersihan-lantai'     => ['Pembersihan Lantai', 'bi-layers'],
                    'pengeluaran-chemical'   => ['Pengeluaran Chemical', 'bi-vial'],
                ];
                foreach ($opsMenus as $uri => $menu): ?>
                <a href="<?= site_url($uri) ?>" class="nav-link <?= str_starts_with(uri_string(), $uri) ? 'active' : '' ?>">
                    <i class="bi <?= $menu[1] ?>"></i> <?= $menu[0] ?>
                </a>
                <?php endforeach; ?>

                <div class="nav-label">Pemeliharaan & Higiene</div>
                <?php
                $maintMenus = [
                    'pembersihan-transportasi' => ['Pembersihan Transportasi', 'bi-truck-flatbed'],
                    'pembersihan-trolly'       => ['Pembersihan Trolly', 'bi-cart-check'],
                    'higiene-personil'         => ['Higiene Personil', 'bi-person-check'],
                ];
                foreach ($maintMenus as $uri => $menu): ?>
                <a href="<?= site_url($uri) ?>" class="nav-link <?= str_starts_with(uri_string(), $uri) ? 'active' : '' ?>">
                    <i class="bi <?= $menu[1] ?>"></i> <?= $menu[0] ?>
                </a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if ($role === 'ahli_gizi'): ?>
                <div class="nav-label">Nutrisi</div>
                <a href="<?= site_url('ahli-gizi/upload') ?>" class="nav-link <?= uri_string() === 'ahli-gizi/upload' ? 'active' : '' ?>">
                    <i class="bi bi-egg-fried"></i> Menu Makanan
                </a>
                <a href="<?= base_url('po') ?>" class="nav-link <?= str_starts_with(uri_string(), 'po') ? 'active' : '' ?>">
                    <i class="bi bi-receipt-cutoff"></i> Purchase Order
                </a>
            <?php endif; ?>

            <?php if ($role === 'pic'): ?>
                <div class="nav-label">General Affairs</div>
                <a href="<?= base_url('po') ?>" class="nav-link <?= str_starts_with(uri_string(), 'po') ? 'active' : '' ?>">
                    <i class="bi bi-receipt-cutoff"></i> Purchase Order
                </a>
                <div class="nav-label">Pengaturan Dapur</div>
                <a href="<?= site_url('pic/settings') ?>" class="nav-link <?= uri_string() === 'pic/settings' ? 'active' : '' ?>">
                    <i class="bi bi-geo-alt-fill"></i> Alamat SPPG
                </a>
            <?php endif; ?>
        </nav>

        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                <?= strtoupper(substr(session()->get('nama') ?? 'U', 0, 1)) ?>
            </div>
            <div class="sidebar-user-info">
                <strong><?= esc(session()->get('nama')) ?></strong>
                <small><?= esc(str_replace('_', ' ', session()->get('role'))) ?></small>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= site_url('profile') ?>" class="btn-topbar p-0" title="Profil" style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;font-size:1rem;color:var(--primary);background:rgba(var(--primary-rgb),0.1);">
                    <i class="bi bi-person-circle"></i>
                </a>
                <a href="<?= site_url('logout') ?>" class="btn-topbar" title="Logout" style="width:32px;height:32px;font-size:0.85rem;">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Topbar -->
    <header class="topbar">
        <div class="topbar-title">
            <h6><?= esc($title ?? 'Dashboard') ?></h6>
            <small><?= date('l, d F Y') ?></small>
        </div>
        <div class="topbar-actions">
            <a href="<?= site_url('logout') ?>" class="btn-topbar" title="Logout">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>

    <!-- Mobile Toggle -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle  = document.getElementById('sidebarToggle');

        toggle?.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });

        overlay?.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });

        // Prevent double submission global fix
        document.addEventListener('submit', function(e) {
            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            
            if (submitBtn && form.checkValidity()) {
                // Disable button in next tick to allow form submission to proceed
                setTimeout(() => {
                    submitBtn.disabled = true;
                }, 10);
                
                // Show loading state
                if (!submitBtn.innerHTML.includes('spinner-border')) {
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Menyimpan...';
                }
            }
        });
    </script>
</body>
</html>
