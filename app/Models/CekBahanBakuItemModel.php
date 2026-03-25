<?php

namespace App\Models;

use CodeIgniter\Model;

class CekBahanBakuItemModel extends Model
{
    protected $table         = 'cek_bahan_baku_items';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'cek_bahan_baku_id', 'tgl_bahan', 'jenis_bahan', 
        'satuan', 'banyaknya', 'jumlah_sesuai', 'kondisi_bahan'
    ];
}
