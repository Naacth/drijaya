<?php
namespace App\Models;
use CodeIgniter\Model;

class StokOpnameModel extends Model
{
    protected $table = 'stok_opname';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'nama_sppg', 'kelurahan_desa', 'kecamatan', 'kabupaten_kota', 'provinsi',
        'periode_awal', 'periode_akhir', 'nama_kepala_sppg', 'nama_akuntan', 'created_by',
    ];
}
