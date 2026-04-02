<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4 animate-in">
    <a href="<?= site_url('pemberitahuan-kerja/show/' . $header['id']) ?>" class="text-decoration-none text-muted mb-3 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail
    </a>
    <h4 class="mb-1" style="font-weight: 700;">Ubah Form Pemberitahuan Hasil Kerja</h4>
    <p class="text-muted small">Kosongkan unggahan jika tidak ingin mengganti file tanda tangan.</p>
</div>

<form action="<?= site_url('pemberitahuan-kerja/update/' . $header['id']) ?>" method="post" enctype="multipart/form-data">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header">
            <h6><i class="bi bi-info-circle me-2"></i>Informasi Surat</h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" name="no_surat" class="form-control" required value="<?= esc($header['no_surat']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required value="<?= esc($header['tanggal']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Divisi</label>
                    <select name="divisi" class="form-select" required>
                        <?php foreach (['PIC Persiapan SIF 1', 'PIC Persiapan SIF 2', 'PIC Cooking'] as $d): ?>
                        <option value="<?= esc($d) ?>" <?= (($header['divisi'] ?? '') === $d) ? 'selected' : '' ?>><?= esc($d) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="data-card mt-4 animate-in" style="animation-delay: 0.15s;">
        <div class="card-header">
            <h6><i class="bi bi-clipboard-data me-2"></i>Detail Pekerjaan</h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama PIC</label>
                    <input type="text" name="nama_pic" class="form-control" required value="<?= esc($header['nama_pic']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-control" required value="<?= esc($header['jam_mulai']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="form-control" required value="<?= esc($header['jam_selesai']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Keterangan Jumlah Item</label>
                    <textarea name="keterangan_jumlah_item" class="form-control" rows="3"><?= esc($header['keterangan_jumlah_item'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Keterangan yang Sudah Dikerjakan</label>
                    <textarea name="keterangan_dikerjakan" class="form-control" rows="3"><?= esc($header['keterangan_dikerjakan'] ?? '') ?></textarea>
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
                        <label class="form-label fw-bold">Mengetahui — Anggota</label>
                        <input type="text" name="nama_anggota" class="form-control mb-2" required value="<?= esc($header['nama_anggota']) ?>">
                        <?php if (!empty($header['ttd_anggota'])): ?>
                        <p class="small text-muted mb-1">File saat ini:</p>
                        <img src="<?= base_url($header['ttd_anggota']) ?>" alt="TTD" class="mb-2" style="max-height:80px;border:1px solid #ddd;border-radius:4px;">
                        <?php endif; ?>
                        <label class="form-label small text-muted">Ganti unggahan (opsional)</label>
                        <input type="file" name="ttd_anggota" class="form-control form-control-sm" accept="image/jpeg,image/png">
                        <div id="preview-anggota" class="mt-2"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border rounded p-3 bg-light">
                        <label class="form-label fw-bold">Penanggung Jawab — PIC</label>
                        <input type="text" name="nama_pj" class="form-control mb-2" value="<?= esc($header['nama_pj'] ?? '') ?>">
                        <?php if (!empty($header['ttd_pj'])): ?>
                        <p class="small text-muted mb-1">File saat ini:</p>
                        <img src="<?= base_url($header['ttd_pj']) ?>" alt="TTD PJ" class="mb-2" style="max-height:80px;border:1px solid #ddd;border-radius:4px;">
                        <?php endif; ?>
                        <label class="form-label small text-muted">Ganti unggahan (opsional)</label>
                        <input type="file" name="ttd_pj" class="form-control form-control-sm" accept="image/jpeg,image/png">
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
    previewImage(document.querySelector('input[name="ttd_anggota"]'), 'preview-anggota');
    previewImage(document.querySelector('input[name="ttd_pj"]'), 'preview-pj');
});
</script>

<?= $this->endSection() ?>
