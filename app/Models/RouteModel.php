<?php

namespace App\Models;

use CodeIgniter\Model;

class RouteModel extends Model
{
    protected $table         = 'routes';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tanggal', 'sppg', 'kecamatan', 'mobil', 'driver', 'created_by', 'status', 'total_porsi'
    ];

    public function getWithCreator()
    {
        return $this->select('routes.*, users.nama as pembuat, users.sppg_id')
                    ->join('users', 'users.id = routes.created_by')
                    ->orderBy('routes.created_at', 'DESC');
    }
}
