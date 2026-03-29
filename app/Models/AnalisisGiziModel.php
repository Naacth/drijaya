<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalisisGiziModel extends Model
{
    protected $table            = 'analisis_gizi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_paket', 'tanggal_sajian', 'sppg_id', 'created_by'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
