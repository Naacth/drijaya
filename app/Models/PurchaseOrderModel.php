<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderModel extends Model
{
    protected $table         = 'purchase_orders';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'user_id', 'nomor_po', 'tanggal', 'vendor', 'menu', 'total',
        'status', 'file_name', 'file_path', 'keterangan'
    ];

    public function getWithUser()
    {
        return $this->select('purchase_orders.*, users.nama as user_nama')
                    ->join('users', 'users.id = purchase_orders.user_id')
                    ->orderBy('purchase_orders.created_at', 'DESC');
    }
}
