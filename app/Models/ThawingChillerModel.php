<?php
namespace App\Models;
use CodeIgniter\Model;

class ThawingChillerModel extends Model
{
    protected $table         = 'monitoring_thawing_chiller';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tanggal', 'nama_petugas', 'created_by',
    ];
}
