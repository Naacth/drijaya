<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuKasModel extends Model
{
    protected $table            = 'buku_kas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['sppg_id', 'created_by', 'tanggal', 'keterangan', 'debet', 'kredit'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getSummary($sppg_id, $start, $end)
    {
        $builder = $this->selectSum('debet')
                        ->selectSum('kredit')
                        ->where('tanggal >=', $start)
                        ->where('tanggal <=', $end);
        
        if ($sppg_id) {
            $builder->where('sppg_id', $sppg_id);
        }

        return $builder->first();
    }
}
