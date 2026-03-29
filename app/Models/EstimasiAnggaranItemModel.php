<?php

namespace App\Models;

use CodeIgniter\Model;

class EstimasiAnggaranItemModel extends Model
{
    protected $table            = 'estimasi_anggaran_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['estimasi_anggaran_id', 'nama_item', 'harga_satuan'];
}
