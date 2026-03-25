<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderItemModel extends Model
{
    protected $table         = 'purchase_order_items';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'po_id', 'nama_barang', 'qty', 'satuan',
        'harga_satuan', 'jumlah_faktual', 'total', 'catatan'
    ];
}
