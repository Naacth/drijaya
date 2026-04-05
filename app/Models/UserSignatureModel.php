<?php
namespace App\Models;
use CodeIgniter\Model;

class UserSignatureModel extends Model
{
    protected $table = 'user_signatures';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'user_id', 
        'ttd_aslap', 'nama_aslap', 
        'ttd_kepala_sppg', 'nama_kepala_sppg', 
        'ttd_ahli_gizi', 'nama_ahli_gizi', 
        'ttd_kepala_koki', 'nama_kepala_koki', 
        'ttd_akuntan', 'nama_akuntan'
    ];
}
