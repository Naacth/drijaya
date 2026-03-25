<?php

namespace App\Models;

use CodeIgniter\Model;

class RelawanModel extends Model
{
    protected $table            = 'relawan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama', 'divisi', 'sppg_id'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getBySppg($sppg_id)
    {
        return $this->where('sppg_id', $sppg_id)->findAll();
    }
}
