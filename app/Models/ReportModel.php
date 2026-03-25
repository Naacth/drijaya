<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $table         = 'reports';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'user_id', 'judul', 'kategori', 'file_name',
        'file_path', 'file_type', 'file_size', 'catatan', 'status'
    ];

    public function getWithUser($sppgId = null)
    {
        $builder = $this->select('reports.*, users.nama as user_nama, users.role as user_role')
                        ->join('users', 'users.id = reports.user_id');
        
        if ($sppgId) {
            $builder->where('users.sppg_id', $sppgId);
        }

        return $builder->orderBy('reports.created_at', 'DESC');
    }

    public function getByUser(int $userId)
    {
        return $this->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();
    }

    public function getByKategori(string $kategori, int $userId = null)
    {
        $builder = $this->where('kategori', $kategori);
        if ($userId) {
            $builder->where('user_id', $userId);
        }
        return $builder->orderBy('created_at', 'DESC')->findAll();
    }

    public function countByStatus(string $status = null)
    {
        if ($status) {
            return $this->where('status', $status)->countAllResults();
        }
        return $this->countAllResults();
    }
}
