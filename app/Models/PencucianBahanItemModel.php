<?php
namespace App\Models;
use CodeIgniter\Model;

class PencucianBahanItemModel extends Model
{
    protected $table         = 'pencucian_bahan_items';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'pencucian_bahan_id', 'nama_bahan', 'bahan_kimia', 'benda_asing', 'tindak_lanjut', 'jam_produksi',
    ];
}
