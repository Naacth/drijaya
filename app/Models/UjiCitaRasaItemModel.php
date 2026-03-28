<?php
namespace App\Models;
use CodeIgniter\Model;

class UjiCitaRasaItemModel extends Model
{
    protected $table         = 'uji_cita_rasa_items';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'uji_cita_rasa_id', 'nama_masakan', 'gramasi_standar', 'gramasi_real', 'masalah', 'penyelesaian',
    ];
}
