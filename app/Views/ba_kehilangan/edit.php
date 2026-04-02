<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4 animate-in">
    <a href="<?= site_url('ba-kehilangan/show/' . $header['id']) ?>" class="text-decoration-none text-muted mb-3 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail
    </a>
    <h4 class="mb-1" style="font-weight: 700;">Ubah Berita Acara Kehilangan Ompreng</h4>
    <p class="text-muted small">Kosongkan unggahan tanda tangan jika tidak ingin mengganti file.</p>
</div>

<form action="<?= site_url('ba-kehilangan/update/' . $header['id']) ?>" method="post" enctype="multipart/form-data">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header">
            <h6><i class="bi bi-info-circle me-2"></i>Informasi Surat</h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" name="no_surat" class="form-control" required value="<?= esc($header['no_surat']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Kejadian</label>
                    <input type="date" name="tanggal_kejadian" class="form-control" required value="<?= esc($header['tanggal_kejadian']) ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="data-card mt-4 animate-in" style="animation-delay: 0.15s;">
        <div class="card-header">
            <h6><i class="bi bi-building me-2"></i>Informasi Sekolah & Distribusi</h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Sekolah</label>
                    <input type="text" name="nama_sekolah" class="form-control" required value="<?= esc($header['nama_sekolah']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Penanggung Jawab Sekolah</label>
                    <input type="text" name="nama_pj_sekolah" class="form-control" required value="<?= esc($header['nama_pj_sekolah']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jam Kehilangan Ompreng</label>
                    <input type="time" name="jam_kehilangan" class="form-control" required value="<?= esc($header['jam_kehilangan']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jam Distribusi</label>
                    <input type="time" name="jam_distribusi" class="form-control" required value="<?= esc($header['jam_distribusi']) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Jumlah Hilang</label>
                    <input type="number" name="jumlah_ompreng_hilang" class="form-control" required value="<?= esc($header['jumlah_ompreng_hilang']) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Jumlah Awal</label>
                    <input type="number" name="jumlah_awal" class="form-control" required value="<?= esc($header['jumlah_awal']) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Jumlah Akhir</label>
                    <input type="number" name="jumlah_akhir" class="form-control" required value="<?= esc($header['jumlah_akhir']) ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="data-card mt-4 animate-in" style="animation-delay: 0.2s;">
        <div class="card-header">
            <h6><i class="bi bi-pen me-2"></i>Tanda Tangan (Upload Gambar)</h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="border rounded p-3 bg-light">
                        <label class="form-label fw-bold">Supir SPPG Bunar Sukamulya</label>
                        <input type="text" name="nama_supir" class="form-control mb-2" required value="<?= esc($header['nama_supir']) ?>">
                        <?php if (!empty($header['ttd_supir'])): ?>
                        <p class="small text-muted mb-1">File saat ini:</p>
                        <img src="<?= base_url($header['ttd_supir']) ?>" alt="TTD Supir" class="mb-2" style="max-height:80px;border:1px solid #ddd;border-radius:4px;">
                        <?php endif; ?>
                        <label class="form-label small text-muted">Ganti unggahan (opsional)</label>
                        <input type="file" name="ttd_supir" class="form-control form-control-sm" accept="image/jpeg,image/png">
                        <div id="preview-supir" class="mt-2"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border rounded p-3 bg-light">
                        <label class="form-label fw-bold">Penanggung Jawab Sekolah</label>
                        <?php if (!empty($header['ttd_pj_sekolah'])): ?>
                        <p class="small text-muted mb-1">File saat ini:</p>
                        <img src="<?= base_url($header['ttd_pj_sekolah']) ?>" alt="TTD PJ" class="mb-2" style="max-height:80px;border:1px solid #ddd;border-radius:4px;">
                        <?php endif; ?>
                        <label class="form-label small text-muted">Ganti unggahan (opsional)</label>
                        <input type="file" name="ttd_pj_sekolah" class="form-control form-control-sm" accept="image/jpeg,image/png">
                        <div id="preview-pj" class="mt-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mt-4 animate-in" style="animation-delay: 0.25s;">
        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function previewImage(input, previewId) {
        input.addEventListener('change', function() {
            const preview = document.getElementById(previewId);
            preview.innerHTML = '';
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxHeight = '80px';
                    img.style.border = '1px solid #ddd';
                    img.style.borderRadius = '4px';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    previewImage(document.querySelector('input[name="ttd_supir"]'), 'preview-supir');
    previewImage(document.querySelector('input[name="ttd_pj_sekolah"]'), 'preview-pj');
});
</script>

<?= $this->endSection() ?>
