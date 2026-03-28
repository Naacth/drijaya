<?php
namespace App\Models;
use CodeIgniter\Model;

class SuhuRuanganModel extends Model
{
    protected $table         = 'catatan_suhu_ruangan';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tanggal',
        'pagi_jam', 'pagi_kelembapan', 'pagi_suhu', 'pagi_keterangan',
        'siang_jam', 'siang_kelembapan', 'siang_suhu', 'siang_keterangan',
        'sore_jam', 'sore_kelembapan', 'sore_suhu', 'sore_keterangan',
        'nama_petugas', 'created_by',
    ];
}
