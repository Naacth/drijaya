<?php

namespace App\Models;

use CodeIgniter\Model;

class RouteItemModel extends Model
{
    protected $table         = 'route_items';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'route_id', 'nama_sekolah', 'porsi_besar', 'porsi_kecil', 'jumlah', 'jam_antar', 'sesi'
    ];
}
