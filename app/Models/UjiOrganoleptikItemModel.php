<?php

namespace App\Models;

use CodeIgniter\Model;

class UjiOrganoleptikItemModel extends Model
{
    protected $table         = 'uji_organoleptik_items';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'uji_organoleptik_id', 'nama_makan',
        'skor_rasa', 'skor_warna', 'skor_aroma', 'skor_tekstur',
        'keterangan',
    ];
}
