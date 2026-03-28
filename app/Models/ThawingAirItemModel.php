<?php
namespace App\Models;
use CodeIgniter\Model;

class ThawingAirItemModel extends Model
{
    protected $table         = 'checklist_thawing_air_items';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'checklist_thawing_air_id', 'nama_bahan', 'jumlah', 'suhu_air', 'waktu_thawing', 'paraf',
    ];
}
