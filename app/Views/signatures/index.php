<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <h4 class="mb-1" style="font-weight: 700;">Pengaturan Tanda Tangan</h4>
        <p class="text-muted small mb-0">Upload tanda tangan format digital (PNG transparan disarankan) untuk otomatis tampil di dokumen PDF.</p>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show animate-in" role="alert">
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="row animate-in" style="animation-delay: 0.1s;">
    <div class="col-12">
        <div class="data-card">
            <div class="card-header border-bottom">
                <h6 class="mb-0"><i class="bi bi-pen me-2"></i>Form Upload Tanda Tangan</h6>
            </div>
            <div class="card-body p-4">
                <form action="<?= site_url('signatures/store') ?>" method="post" enctype="multipart/form-data">
                    <div class="row g-4">
                        <!-- TTD Aslap -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">1. Tanda Tangan Asisten Lapangan (Anda)</label>
                            <input type="text" name="nama_aslap" class="form-control mb-2" placeholder="Masukkan nama Asisten Lapangan..." value="<?= esc($signature['nama_aslap'] ?? '') ?>">
                            <input type="file" name="ttd_aslap" class="form-control mb-2" accept="image/*" onchange="previewImage(this, 'preview-aslap')">
                            <div class="p-3 border rounded text-center bg-light mt-2" style="min-height: 120px; display: flex; align-items: center; justify-content: center;">
                                <?php if (!empty($signature['ttd_aslap'])): ?>
                                    <img src="<?= base_url('uploads/signatures/' . $signature['ttd_aslap']) ?>" id="preview-aslap" style="max-height: 100px; max-width: 100%; object-fit: contain;">
                                <?php else: ?>
                                    <img src="" id="preview-aslap" style="max-height: 100px; max-width: 100%; object-fit: contain; display: none;">
                                    <span class="text-muted small" id="text-aslap">Belum ada tanda tangan</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- TTD Kepala SPPG -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">2. Tanda Tangan Kepala SPPG</label>
                            <input type="text" name="nama_kepala_sppg" class="form-control mb-2" placeholder="Masukkan nama Kepala SPPG..." value="<?= esc($signature['nama_kepala_sppg'] ?? '') ?>">
                            <input type="file" name="ttd_kepala_sppg" class="form-control mb-2" accept="image/*" onchange="previewImage(this, 'preview-kepala')">
                            <div class="p-3 border rounded text-center bg-light mt-2" style="min-height: 120px; display: flex; align-items: center; justify-content: center;">
                                <?php if (!empty($signature['ttd_kepala_sppg'])): ?>
                                    <img src="<?= base_url('uploads/signatures/' . $signature['ttd_kepala_sppg']) ?>" id="preview-kepala" style="max-height: 100px; max-width: 100%; object-fit: contain;">
                                <?php else: ?>
                                    <img src="" id="preview-kepala" style="max-height: 100px; max-width: 100%; object-fit: contain; display: none;">
                                    <span class="text-muted small" id="text-kepala">Belum ada tanda tangan</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- TTD Ahli Gizi -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">3. Tanda Tangan Ahli Gizi</label>
                            <input type="text" name="nama_ahli_gizi" class="form-control mb-2" placeholder="Masukkan nama Ahli Gizi..." value="<?= esc($signature['nama_ahli_gizi'] ?? '') ?>">
                            <input type="file" name="ttd_ahli_gizi" class="form-control mb-2" accept="image/*" onchange="previewImage(this, 'preview-gizi')">
                            <div class="p-3 border rounded text-center bg-light mt-2" style="min-height: 120px; display: flex; align-items: center; justify-content: center;">
                                <?php if (!empty($signature['ttd_ahli_gizi'])): ?>
                                    <img src="<?= base_url('uploads/signatures/' . $signature['ttd_ahli_gizi']) ?>" id="preview-gizi" style="max-height: 100px; max-width: 100%; object-fit: contain;">
                                <?php else: ?>
                                    <img src="" id="preview-gizi" style="max-height: 100px; max-width: 100%; object-fit: contain; display: none;">
                                    <span class="text-muted small" id="text-gizi">Belum ada tanda tangan</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- TTD Kepala Koki -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">4. Tanda Tangan Kepala Koki Satuan Pelayanan</label>
                            <input type="text" name="nama_kepala_koki" class="form-control mb-2" placeholder="Masukkan nama Kepala Koki..." value="<?= esc($signature['nama_kepala_koki'] ?? '') ?>">
                            <input type="file" name="ttd_kepala_koki" class="form-control mb-2" accept="image/*" onchange="previewImage(this, 'preview-koki')">
                            <div class="p-3 border rounded text-center bg-light mt-2" style="min-height: 120px; display: flex; align-items: center; justify-content: center;">
                                <?php if (!empty($signature['ttd_kepala_koki'])): ?>
                                    <img src="<?= base_url('uploads/signatures/' . $signature['ttd_kepala_koki']) ?>" id="preview-koki" style="max-height: 100px; max-width: 100%; object-fit: contain;">
                                <?php else: ?>
                                    <img src="" id="preview-koki" style="max-height: 100px; max-width: 100%; object-fit: contain; display: none;">
                                    <span class="text-muted small" id="text-koki">Belum ada tanda tangan</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- TTD Akuntan -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">5. Tanda Tangan Akuntan</label>
                            <input type="text" name="nama_akuntan" class="form-control mb-2" placeholder="Masukkan nama Akuntan..." value="<?= esc($signature['nama_akuntan'] ?? '') ?>">
                            <input type="file" name="ttd_akuntan" class="form-control mb-2" accept="image/*" onchange="previewImage(this, 'preview-akuntan')">
                            <div class="p-3 border rounded text-center bg-light mt-2" style="min-height: 120px; display: flex; align-items: center; justify-content: center;">
                                <?php if (!empty($signature['ttd_akuntan'])): ?>
                                    <img src="<?= base_url('uploads/signatures/' . $signature['ttd_akuntan']) ?>" id="preview-akuntan" style="max-height: 100px; max-width: 100%; object-fit: contain;">
                                <?php else: ?>
                                    <img src="" id="preview-akuntan" style="max-height: 100px; max-width: 100%; object-fit: contain; display: none;">
                                    <span class="text-muted small" id="text-akuntan">Belum ada tanda tangan</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top text-end">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan Tanda Tangan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input, imgId) {
    const preview = document.getElementById(imgId);
    const textSpan = document.getElementById('text-' + imgId.split('-')[1]);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (textSpan) textSpan.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?= $this->endSection() ?>
