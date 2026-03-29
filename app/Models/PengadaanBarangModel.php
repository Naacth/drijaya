<?php

namespace App\Models;

use CodeIgniter\Model;

class PengadaanBarangModel extends Model
{
    protected $table         = 'pengadaan_barang';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tanggal', 'nama_barang', 'jumlah', 'satuan',
        'estimasi_harga', 'alasan', 'status',
        'created_by',
    ];
}
