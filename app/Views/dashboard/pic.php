<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    .welcome-banner {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        border-radius: 12px;
        padding: 30px;
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4);
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
        color: #10b981;
    }
    .q-menu-icon {
        font-size: 32px;
        margin-bottom: 10px;
    }
</style>

<div class="welcome-banner animate-in">
    <h3 class="fw-bold mb-2">Selamat Datang, <?= esc(session()->get('nama')) ?>!</h3>
    <p class="mb-0 opacity-75" style="font-size: 1.1rem;">Anda mengelola operasional untuk <strong><?= esc($sppg_name) ?></strong></p>
</div>

<h5 class="fw-bold mb-3" style="color: #334155;">Ringkasan Data</h5>
<div class="row g-4 mb-5">
    <div class="col-12 col-sm-6 col-lg-4 animate-in" style="animation-delay: 0.1s;">
        <a href="<?= site_url('po') ?>" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #6366f1, #4f46e5);">
                    <i class="bi bi-receipt-cutoff"></i>
                </div>
                <div class="stat-info">
                    <h3><?= number_format($totalPO) ?></h3>
                    <p>Purchase Order</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-12 col-sm-6 col-lg-4 animate-in" style="animation-delay: 0.2s;">
        <a href="<?= site_url('pengajuan-barang-rusak') ?>" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                    <i class="bi bi-tools"></i>
                </div>
                <div class="stat-info">
                    <h3><?= number_format($barangRusakCount) ?></h3>
                    <p>Barang Rusak</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-12 col-sm-6 col-lg-4 animate-in" style="animation-delay: 0.3s;">
        <a href="<?= site_url('pengadaan-barang') ?>" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="bi bi-cart-plus"></i>
                </div>
                <div class="stat-info">
                    <h3><?= number_format($pengadaanCount) ?></h3>
                    <p>Pengadaan Barang</p>
                </div>
            </div>
        </a>
    </div>
</div>

<h5 class="fw-bold mb-3" style="color: #334155;">Akses Cepat Modul</h5>
<div class="row g-3 animate-in" style="animation-delay: 0.4s;">
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
