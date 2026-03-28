<?php
namespace App\Models;
use CodeIgniter\Model;

class MonitoringSuhuMasakItemModel extends Model
{
    protected $table         = 'monitoring_suhu_masak_items';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'monitoring_suhu_masak_id', 'nama_makanan', 'suhu_pemasakan', 'jam_matang', 'jadwal_penyajian',
    ];
}
