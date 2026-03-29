<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    .welcome-banner {
        background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
        color: #fff;
        border-radius: 12px;
        padding: 30px;
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 10px 25px -5px rgba(139, 92, 246, 0.4);
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
</style>

<div class="welcome-banner animate-in">
    <h3 class="fw-bold mb-2">Selamat Datang, <?= esc(session()->get('nama')) ?>!</h3>
    <p class="mb-0 opacity-75" style="font-size: 1.1rem;">Panel Manajemen Gizi & Mutu untuk <strong><?= esc($sppg_name) ?></strong></p>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-lg-4 animate-in" style="animation-delay: 0.1s;">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                <i class="bi bi-egg-fried"></i>
            </div>
            <div class="stat-info">
                <h3><?= number_format($totalMenu) ?></h3>
                <p>Total Menu Upload</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-4 animate-in" style="animation-delay: 0.2s;">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-info">
                <h3><?= number_format($pendingMenu) ?></h3>
                <p>Menunggu Review</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-4 animate-in" style="animation-delay: 0.3s;">
        <a href="<?= site_url('checklist-masakan') ?>" class="text-decoration-none w-100">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="bi bi-clipboard-check"></i>
                </div>
                <div class="stat-info">
                    <h3 style="font-size: 1.2rem;">QC Masakan</h3>
                    <p>Buka Checklist</p>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Upload Form -->
    <div class="col-lg-5 animate-in" style="animation-delay: 0.4s;">
        <div class="data-card">
            <div class="card-header">
                <h6><i class="bi bi-cloud-upload me-2"></i>Upload Menu Makanan</h6>
            </div>
            <div class="card-body p-4">
                <form action="<?= site_url('ahli-gizi/upload') ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Judul Menu</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Menu Harian 8 Maret 2026">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File Dokumen <span class="text-danger">*</span></label>
                        <div class="upload-zone" id="uploadZone" onclick="document.getElementById('fileInput').click()">
                            <i class="bi bi-cloud-arrow-up d-block"></i>
                            <p class="mb-1 fw-semibold" style="font-size:0.9rem;">Klik atau drag file ke sini</p>
                            <small class="text-muted">PDF, Word, Excel (Maks. 10MB)</small>
                            <input type="file" name="file" id="fileInput" class="d-none"
                                   accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                        </div>
                        <div id="fileName" class="mt-2 small text-muted"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan tambahan (opsional)"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-send-fill me-1"></i> Kirim ke Admin
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- History -->
    <div class="col-lg-7 animate-in" style="animation-delay: 0.5s;">
        <div class="data-card">
            <div class="card-header">
                <h6><i class="bi bi-clock-history me-2"></i>Riwayat Upload Menu</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-premium">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>File</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($reports)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                Belum ada menu yang dikirimkan
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($reports as $r): ?>
                        <tr>
                            <td class="fw-bold"><?= esc($r['judul']) ?></td>
                            <td>
                                <a href="<?= base_url($r['file_path']) ?>" target="_blank" class="text-decoration-none">
                                    <span class="badge bg-light text-primary border"><i class="bi bi-file-earmark-pdf me-1"></i><?= esc($r['file_name']) ?></span>
                                </a>
                            </td>
                            <td><?= date('d M Y', strtotime($r['created_at'])) ?></td>
                            <td><span class="badge-status badge-<?= $r['status'] ?>"><?= ucfirst($r['status']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('fileInput')?.addEventListener('change', function() {
        const zone = document.getElementById('uploadZone');
        const nameEl = document.getElementById('fileName');
        if (this.files.length) {
            nameEl.innerHTML = '<i class="bi bi-file-earmark-check text-success me-1"></i><strong>' + this.files[0].name + '</strong>';
            zone.style.borderColor = '#6366f1';
        }
    });
</script>

<?= $this->endSection() ?>
