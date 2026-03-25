<?php

namespace App\Models;

use CodeIgniter\Model;

class BeneficiaryModel extends Model
{
    protected $table         = 'beneficiaries';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tanggal', 'sppg', 'kecamatan', 'created_by', 'status'
    ];

    public function getWithCreator()
    {
        return $this->select('beneficiaries.*, users.nama as pembuat')
                    ->join('users', 'users.id = beneficiaries.created_by')
                    ->orderBy('beneficiaries.created_at', 'DESC');
    }
}
