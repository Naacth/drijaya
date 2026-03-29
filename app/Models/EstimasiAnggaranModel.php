<?php

namespace App\Models;

use CodeIgniter\Model;

class EstimasiAnggaranModel extends Model
{
    protected $table            = 'estimasi_anggaran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['tanggal_mulai', 'tanggal_selesai', 'kategori_porsi', 'total_kalkulasi', 'sppg_id', 'created_by'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
