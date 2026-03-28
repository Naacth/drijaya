<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Form Sanitasi Ruangan & Peralatan</h5>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('sanitasi-ruangan/store') ?>" method="post">
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Tanggal Pemeriksaan</label>
                                <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>

                        <h6 class="mb-3 text-primary border-bottom pb-2">Checklist Fasilitas (Bersih = Centang)</h6>
                        <div class="row">
                            <?php 
                            $items = ['Lantai', 'Dinding', 'Meja Persiapan', 'Steamer', 'Chopper', 'Blender', 'Talenan', 'Pisau', 'Kompor', 'Rak Alat', 'Sink'];
                            foreach ($items as $item): 
                                $key = strtolower(str_replace(' ', '_', $item));
                            ?>
                            <div class="col-md-6 mb-2">
                                <div class="form-check form-switch p-2 border rounded">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="fasilitas[<?= $key ?>]" value="1" id="<?= $key ?>">
                                    <label class="form-check-label" for="<?= $key ?>"><?= $item ?></label>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Pelaksana</label>
                                <input type="text" name="nama_pelaksana" class="form-control" placeholder="Nama petugas pelaksana" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Pemeriksa</label>
                                <input type="text" name="nama_pemeriksa" class="form-control" placeholder="Nama ahli gizi/pengawas" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= site_url('sanitasi-ruangan') ?>" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
