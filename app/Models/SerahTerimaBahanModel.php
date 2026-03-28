<?php
namespace App\Models;
use CodeIgniter\Model;

class SerahTerimaBahanModel extends Model
{
    protected $table         = 'serah_terima_bahan';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tanggal', 'nama_pengirim', 'nama_penerima', 'created_by',
    ];
}
