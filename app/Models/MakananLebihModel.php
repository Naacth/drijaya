<?php
namespace App\Models;
use CodeIgniter\Model;

class MakananLebihModel extends Model
{
    protected $table         = 'makanan_lebih';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tanggal', 'nama_cook', 'nama_chef', 'nama_ahli_gizi', 'created_by',
    ];
}
