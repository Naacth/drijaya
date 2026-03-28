<?php
namespace App\Models;
use CodeIgniter\Model;

class SuhuChillerFreezerModel extends Model
{
    protected $table         = 'suhu_chiller_freezer';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tanggal',
        'chiller_pagi', 'chiller_siang', 'chiller_malam',
        'freezer_pagi', 'freezer_siang', 'freezer_malam',
        'kebersihan_rak', 'verifikasi', 'nama_petugas', 'created_by',
    ];
}
