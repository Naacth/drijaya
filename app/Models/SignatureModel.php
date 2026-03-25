<?php

namespace App\Models;

use CodeIgniter\Model;

class SignatureModel extends Model
{
    protected $table         = 'signatures';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'pic_id', 'sppg_name',
        'nama_akuntan', 'ttd_akuntan',
        'nama_ahli_gizi', 'ttd_ahli_gizi',
        'nama_kepala_dapur', 'ttd_kepala_dapur'
    ];
}
