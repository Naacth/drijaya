<?php
namespace App\Models;
use CodeIgniter\Model;

class UjiCitaRasaModel extends Model
{
    protected $table         = 'uji_cita_rasa';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tanggal', 'nama_checker', 'nama_chef', 'nama_ahli_gizi', 'created_by',
    ];
}
