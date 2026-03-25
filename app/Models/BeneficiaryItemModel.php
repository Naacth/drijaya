<?php

namespace App\Models;

use CodeIgniter\Model;

class BeneficiaryItemModel extends Model
{
    protected $table         = 'beneficiary_items';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'beneficiary_id', 'nama_sekolah', 'jumlah_siswa', 
        'porsi_kecil', 'porsi_besar', 'pendidik', 
        'non_pendidik', 'total_porsi'
    ];
}
