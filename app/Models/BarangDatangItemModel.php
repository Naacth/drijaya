<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangDatangItemModel extends Model
{
    protected $table         = 'barang_datang_items';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'barang_datang_id', 'nama_barang', 'satuan', 
        'banyak_barang', 'keterangan', 'nama_qc', 'nama_pemasok'
    ];
}
