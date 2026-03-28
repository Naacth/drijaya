<?php
namespace App\Models;
use CodeIgniter\Model;

class MonitoringSuhuMasakModel extends Model
{
    protected $table         = 'monitoring_suhu_masak';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tanggal', 'nama_pelaksana', 'nama_pemeriksa', 'created_by',
    ];
}
