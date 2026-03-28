<?php
namespace App\Models;
use CodeIgniter\Model;

class SerahTerimaBahanItemModel extends Model
{
    protected $table         = 'serah_terima_bahan_items';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'serah_terima_bahan_id', 'jam', 'nama_bahan', 'tujuan_penggunaan',
        'gramasi_per_porsi', 'jumlah_awal', 'jumlah_tidak_layak', 'tindak_lanjut', 'jumlah_akhir',
    ];
}
