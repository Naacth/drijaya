<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <!-- Upload Form -->
    <div class="col-lg-5 animate-in">
        <div class="data-card">
            <div class="card-header">
                <h6><i class="bi bi-cloud-arrow-up me-2"></i>Upload <?= esc($label) ?></h6>
            </div>
            <div class="card-body p-4">
                <?php
                    $role = session()->get('role');
                    if ($role === 'aslap') {
                        $actionUrl = site_url('aslap/upload');
                    } elseif ($role === 'akuntan') {
                        $actionUrl = site_url('akuntan/upload');
                    } else {
                        $actionUrl = site_url('ahli-gizi/upload');
                    }
                ?>
                <form action="<?= $actionUrl ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="kategori" value="<?= esc($kategori) ?>">

                    <div class="mb-3">
                        <label class="form-label">Judul Laporan</label>
                        <input type="text" name="judul" class="form-control" placeholder="Judul laporan (opsional)">
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
    <div class="col-lg-7 animate-in">
        <div class="data-card">
            <div class="card-header">
                <h6><i class="bi bi-clock-history me-2"></i>Riwayat Upload — <?= esc($label) ?></h6>
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
                            <td colspan="4" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Belum ada laporan dikirim
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($reports as $r): ?>
                        <tr>
                            <td><?= esc($r['judul']) ?></td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    <i class="bi bi-file-earmark me-1"></i><?= esc($r['file_name']) ?>
                                </span>
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
    document.getElementById('fileInput').addEventListener('change', function() {
        const zone = document.getElementById('uploadZone');
        const nameEl = document.getElementById('fileName');
        if (this.files.length) {
            nameEl.innerHTML = '<i class="bi bi-file-earmark-check text-success me-1"></i><strong>' + this.files[0].name + '</strong>';
            zone.style.borderColor = '#6366f1';
        }
    });

    // Drag and drop
    const zone = document.getElementById('uploadZone');
    ['dragenter','dragover'].forEach(e => zone.addEventListener(e, ev => { ev.preventDefault(); zone.classList.add('dragover'); }));
    ['dragleave','drop'].forEach(e => zone.addEventListener(e, ev => { ev.preventDefault(); zone.classList.remove('dragover'); }));
    zone.addEventListener('drop', ev => {
        const input = document.getElementById('fileInput');
        input.files = ev.dataTransfer.files;
        input.dispatchEvent(new Event('change'));
    });
</script>

<?= $this->endSection() ?>
