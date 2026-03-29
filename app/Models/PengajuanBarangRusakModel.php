<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanBarangRusakModel extends Model
{
    protected $table         = 'pengajuan_barang_rusak';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tanggal', 'nama_barang', 'jumlah', 'satuan',
        'kondisi', 'keterangan', 'foto', 'status',
        'created_by',
    ];
}
