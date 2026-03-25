<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiItemModel extends Model
{
    protected $table            = 'absensi_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['absensi_id', 'relawan_id', 'status'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getByAbsensi($absensi_id)
    {
        return $this->select('absensi_items.*, relawan.nama, relawan.divisi')
                    ->join('relawan', 'relawan.id = absensi_items.relawan_id')
                    ->where('absensi_id', $absensi_id)
                    ->findAll();
    }
}
