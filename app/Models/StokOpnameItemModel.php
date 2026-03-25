<?php
namespace App\Models;
use CodeIgniter\Model;

class StokOpnameItemModel extends Model
{
    protected $table = 'stok_opname_items';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'stok_opname_id', 'hari_ke', 'nama_bahan', 'satuan',
        'stok_fisik', 'stok_di_kartu', 'selisih', 'keterangan',
    ];
}
