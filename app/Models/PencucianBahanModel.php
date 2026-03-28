<?php
namespace App\Models;
use CodeIgniter\Model;

class PencucianBahanModel extends Model
{
    protected $table         = 'pencucian_bahan';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tanggal', 'nama_petugas', 'created_by',
    ];
}
