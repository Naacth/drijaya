<?php
namespace App\Models;
use CodeIgniter\Model;

class PemeriksaanSampelModel extends Model
{
    protected $table         = 'pemeriksaan_sampel';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tanggal', 'jam_matang', 'jenis_produk', 'bahaya_fisik', 'bahaya_biologi',
        'jam_penarikan', 'tindak_lanjut', 'sampel_diambil', 'jumlah_sampel',
        'tempat_penyimpanan', 'tanggal_pemusnahan', 'nama_pemeriksa', 'created_by',
    ];
}
