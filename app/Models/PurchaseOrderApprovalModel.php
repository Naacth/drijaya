<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderApprovalModel extends Model
{
    protected $table         = 'purchase_order_approvals';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false; // We use created_at only
    protected $allowedFields = [
        'po_id', 'role', 'user_id', 'status', 'catatan', 'created_at'
    ];
}
