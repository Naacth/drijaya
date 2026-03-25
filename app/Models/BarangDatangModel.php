<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangDatangModel extends Model
{
    protected $table         = 'barang_datang';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['tanggal', 'penanggung_jawab', 'created_by', 'status'];

    public function getWithCreator()
    {
        $this->select('barang_datang.*, users.nama as pembuat_nama, users.role as pembuat_role');
        $this->join('users', 'users.id = barang_datang.created_by');
        $this->orderBy('barang_datang.created_at', 'DESC');
        return $this;
    }
}
