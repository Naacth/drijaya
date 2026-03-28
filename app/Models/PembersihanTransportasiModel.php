<?php

namespace App\Models;

use CodeIgniter\Model;

class PembersihanTransportasiModel extends Model
{
    protected $table = 'pembersihan_transportasi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['bulan', 'tahun', 'nama_kendaraan', 'rekap_data', 'created_by', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
