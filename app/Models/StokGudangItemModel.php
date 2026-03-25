<?php

namespace App\Models;

use CodeIgniter\Model;

class StokGudangItemModel extends Model
{
    protected $table         = 'stok_gudang_items';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'stok_gudang_id', 'nama_produk', 'nama_penerima',
        'stok_awal', 'barang_masuk', 'barang_keluar', 'stok_akhir',
    ];
}
