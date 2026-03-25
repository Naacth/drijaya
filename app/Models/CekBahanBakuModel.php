<?php

namespace App\Models;

use CodeIgniter\Model;

class CekBahanBakuModel extends Model
{
    protected $table         = 'cek_bahan_baku';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['tanggal_laporan', 'nama_sppg', 'alamat_sppg', 'nama_kepala_sppg', 'created_by', 'status'];

    public function getWithCreator()
    {
        $this->select('cek_bahan_baku.*, users.nama as user_nama, users.role as user_role');
        $this->join('users', 'users.id = cek_bahan_baku.created_by');
        $this->orderBy('cek_bahan_baku.created_at', 'DESC');
        return $this;
    }
}
