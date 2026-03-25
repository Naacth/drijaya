<?php

namespace App\Models;

use CodeIgniter\Model;

class PemberitahuanKerjaModel extends Model
{
    protected $table         = 'pemberitahuan_kerja';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'no_surat', 'tanggal', 'divisi', 'nama_pic',
        'jam_mulai', 'jam_selesai',
        'keterangan_jumlah_item', 'keterangan_dikerjakan',
        'nama_anggota', 'ttd_anggota', 'nama_pj', 'ttd_pj',
        'created_by',
    ];
}
