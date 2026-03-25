<?php

namespace App\Models;

use CodeIgniter\Model;

class BaKehilanganModel extends Model
{
    protected $table         = 'ba_kehilangan';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'no_surat', 'nama_sekolah', 'nama_pj_sekolah',
        'jam_kehilangan', 'jam_distribusi', 'tanggal_kejadian',
        'jumlah_ompreng_hilang', 'jumlah_awal', 'jumlah_akhir',
        'ttd_supir', 'nama_supir', 'ttd_pj_sekolah',
        'created_by',
    ];
}
