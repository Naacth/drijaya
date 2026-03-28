<?php
namespace App\Models;
use CodeIgniter\Model;

class MakananLebihItemModel extends Model
{
    protected $table         = 'makanan_lebih_items';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'makanan_lebih_id', 'nama_item', 'jumlah', 'kondisi', 'tindakan',
    ];
}
