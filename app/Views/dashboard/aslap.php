<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    /* Styling for the Aslap Dashboard */
    .welcome-banner {
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
        color: #fff;
        border-radius: 12px;
        padding: 30px;
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4);
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        top: -50%; right: -10%;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
    }
    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid rgba(0,0,0,0.03);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
    }
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #fff;
        margin-right: 15px;
    }
    .stat-info h3 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
    }
    .stat-info p {
        margin: 0;
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .q-menu-card {
        background: #fff;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        text-decoration: none;
        color: #334155;
        display: block;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        border: 1px solid rgba(0,0,0,0.04);
        transition: all 0.2s;
    }
    .q-menu-card:hover {
        background: #f8fafc;
        transform: translateY(-3px);
        box-shadow: 0 8px 12px rgba(0,0,0,0.05);
        color: #4f46e5;
    }
    .q-menu-icon {
        font-size: 32px;
        margin-bottom: 10px;
    }
</style>

<div class="welcome-banner animate-in">
    <h3 class="fw-bold mb-2">Selamat Datang, <?= esc(session()->get('name')) ?>!</h3>
    <p class="mb-0 opacity-75" style="font-size: 1.1rem;">Anda mengelola operasional untuk <strong><?= esc($sppg_name) ?></strong></p>
</div>

<h5 class="fw-bold mb-3" style="color: #334155;">Ringkasan Formulir</h5>
<div class="row g-4 mb-5">
    <!-- Stat 1 -->
    <div class="col-12 col-sm-6 col-lg-3 animate-in" style="animation-delay: 0.1s;">
        <a href="<?= site_url('barang-datang') ?>" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="stat-info">
                    <h3><?= number_format($stats['barang_datang']) ?></h3>
                    <p>Barang Datang</p>
                </div>
            </div>
        </a>
    </div>
    <!-- Stat 2 -->
    <div class="col-12 col-sm-6 col-lg-3 animate-in" style="animation-delay: 0.2s;">
        <a href="<?= site_url('cek-bahan-baku') ?>" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="bi bi-clipboard-check"></i>
                </div>
                <div class="stat-info">
                    <h3><?= number_format($stats['cek_bahan']) ?></h3>
                    <p>Cek Bahan</p>
                </div>
            </div>
        </a>
    </div>
    <!-- Stat 3 -->
    <div class="col-12 col-sm-6 col-lg-3 animate-in" style="animation-delay: 0.3s;">
        <a href="<?= site_url('uji-organoleptik') ?>" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <i class="bi bi-eyedropper"></i>
                </div>
                <div class="stat-info">
                    <h3><?= number_format($stats['uji_organoleptik']) ?></h3>
                    <p>Uji Organoleptik</p>
                </div>
            </div>
        </a>
    </div>
    <!-- Stat 4 -->
    <div class="col-12 col-sm-6 col-lg-3 animate-in" style="animation-delay: 0.4s;">
        <a href="<?= site_url('ba-kehilangan') ?>" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="stat-info">
                    <h3><?= number_format($stats['ba_kehilangan']) ?></h3>
                    <p>BA Kehilangan</p>
                </div>
            </div>
        </a>
    </div>
</div>

<h5 class="fw-bold mb-3" style="color: #334155;">Akses Cepat Modul</h5>
<div class="row g-3 animate-in" style="animation-delay: 0.5s;">
    <?php foreach ($menus as $label => $menu): ?>
    <div class="col-6 col-md-4 col-lg-3">
        <a href="<?= site_url($menu['route']) ?>" class="q-menu-card">
            <div class="q-menu-icon" style="color: <?= $menu['color'] ?>;">
                <i class="bi <?= $menu['icon'] ?>"></i>
            </div>
            <h6 class="mb-0 fw-bold" style="font-size: 0.9rem;"><?= esc($label) ?></h6>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
