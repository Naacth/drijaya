<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalisisGiziItemModel extends Model
{
    protected $table            = 'analisis_gizi_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'analisis_gizi_id', 'nama_item', 'gramasi', 'kalori', 'protein', 'lemak', 'karbohidrat', 'serat'
    ];
}
