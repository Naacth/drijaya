<?php

namespace App\Models;

use CodeIgniter\Model;

class HigienePersonilModel extends Model
{
    protected $table = 'higiene_personil';
    protected $primaryKey = 'id';
    protected $allowedFields = ['bulan', 'tahun', 'rekap_data', 'created_by', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
