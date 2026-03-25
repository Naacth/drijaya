<?php
namespace App\Models;
use CodeIgniter\Model;

class RekapPorsiModel extends Model
{
    protected $table = 'rekap_porsi';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['tanggal', 'created_by'];
}
