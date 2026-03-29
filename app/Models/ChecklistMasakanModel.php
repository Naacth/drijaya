<?php

namespace App\Models;

use CodeIgniter\Model;

class ChecklistMasakanModel extends Model
{
    protected $table            = 'checklist_masakan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['tanggal', 'waktu_penyajian', 'sppg_id', 'created_by'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
