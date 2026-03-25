<?php

namespace App\Models;

use CodeIgniter\Model;

class StokGudangModel extends Model
{
    protected $table         = 'stok_gudang';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama_sppg', 'tanggal', 'created_by'];
}
