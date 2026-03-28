<?php
namespace App\Models;
use CodeIgniter\Model;

class ThawingAirModel extends Model
{
    protected $table         = 'checklist_thawing_air';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tanggal', 'nama_petugas', 'created_by',
    ];
}
