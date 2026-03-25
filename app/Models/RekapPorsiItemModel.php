<?php
namespace App\Models;
use CodeIgniter\Model;

class RekapPorsiItemModel extends Model
{
    protected $table = 'rekap_porsi_items';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'rekap_porsi_id', 'tingkatan', 'sekolah', 'jumlah_pm',
        'jumlah_terdistribusi', 'jumlah_tidak_terdistribusi',
        'keterangan', 'pengalihan'
    ];
}
