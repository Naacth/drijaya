<?php

namespace App\Models;

use CodeIgniter\Model;

class UjiOrganoleptikModel extends Model
{
    protected $table         = 'uji_organoleptik';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'nama_pemeriksa', 'tempat_pemeriksaan', 'nama_tempat',
        'tanggal_pemeriksaan', 'waktu_pemeriksaan', 'waktu_uji',
        'nama_aslap', 'nama_pemeriksa_plok', 'nama_kepala_sppg',
        'created_by',
    ];
}
