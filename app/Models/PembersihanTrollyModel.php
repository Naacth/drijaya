<?php

namespace App\Models;

use CodeIgniter\Model;

class PembersihanTrollyModel extends Model
{
    protected $table = 'pembersihan_trolly';
    protected $primaryKey = 'id';
    protected $allowedFields = ['bulan', 'tahun', 'rekap_data', 'created_by', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
