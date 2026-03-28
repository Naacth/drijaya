<?php
namespace App\Models;
use CodeIgniter\Model;

class ThawingChillerItemModel extends Model
{
    protected $table         = 'monitoring_thawing_chiller_items';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'monitoring_thawing_chiller_id', 'nama_bahan', 'jumlah',
        'tgl_jam_keluar_freezer', 'tgl_jam_selesai_thawing', 'tgl_jam_pemasakan', 'paraf',
    ];
}
