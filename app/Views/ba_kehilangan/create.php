<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'ba-kehilangan/export-pdf-blank']) ?>



<div class="mb-4 animate-in">
    <a href="<?= site_url('ba-kehilangan') ?>" class="text-decoration-none text-muted mb-3 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
    </a>
    <h4 class="mb-1" style="font-weight: 700;">Buat Berita Acara Kehilangan Ompreng</h4>
    <p class="text-muted small">Isi detail berita acara kehilangan ompreng beserta tanda tangan.</p>
</div>

<form action="<?= site_url('ba-kehilangan/store') ?>" method="post" enctype="multipart/form-data">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header">
            <h6><i class="bi bi-info-circle me-2"></i>Informasi Surat</h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" name="no_surat" class="form-control" placeholder="Contoh: 001/SPPG-BUNAR/<?= date('Y') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Kejadian</label>
                    <input type="date" name="tanggal_kejadian" class="form-control" required value="<?= date('Y-m-d') ?>">
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
                    <input type="text" name="nama_sekolah" class="form-control" placeholder="Nama sekolah penerima" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Penanggung Jawab Sekolah</label>
                    <input type="text" name="nama_pj_sekolah" class="form-control" placeholder="Nama PJ di sekolah" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jam Kehilangan Ompreng</label>
                    <input type="time" name="jam_kehilangan" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jam Distribusi</label>
                    <input type="time" name="jam_distribusi" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Jumlah Hilang</label>
                    <input type="number" name="jumlah_ompreng_hilang" class="form-control" placeholder="Pcs" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Jumlah Awal</label>
                    <input type="number" name="jumlah_awal" class="form-control" placeholder="Pcs" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Jumlah Akhir</label>
                    <input type="number" name="jumlah_akhir" class="form-control" placeholder="Pcs" required>
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
                        <input type="text" name="nama_supir" class="form-control mb-2" placeholder="Nama Supir" required>
                        <label class="form-label small text-muted">Upload Tanda Tangan Supir (JPG/PNG)</label>
                        <input type="file" name="ttd_supir" class="form-control form-control-sm" accept="image/jpeg,image/png">
                        <div id="preview-supir" class="mt-2"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border rounded p-3 bg-light">
                        <label class="form-label fw-bold">Penanggung Jawab Sekolah</label>
                        <p class="text-muted small mb-2">Nama PJ sudah diisi di atas.</p>
                        <label class="form-label small text-muted">Upload Tanda Tangan PJ Sekolah (JPG/PNG)</label>
                        <input type="file" name="ttd_pj_sekolah" class="form-control form-control-sm" accept="image/jpeg,image/png">
                        <div id="preview-pj" class="mt-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mt-4 animate-in" style="animation-delay: 0.25s;">
        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan Berita Acara</button>
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
