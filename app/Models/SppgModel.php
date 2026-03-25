<?php

namespace App\Models;

use CodeIgniter\Model;

class SppgModel extends Model
{
    protected $table         = 'sppgs';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama_sppg'];
}
