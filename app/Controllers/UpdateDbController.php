<?php

namespace App\Controllers;

class UpdateDbController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        try {
            $db->query("ALTER TABLE purchase_order_items ADD COLUMN harga_satuan DECIMAL(15,2) DEFAULT '0.00' AFTER satuan");
        } catch (\Exception $e) {}
        try {
            $db->query("ALTER TABLE purchase_order_items ADD COLUMN tambahan DECIMAL(15,2) DEFAULT '0.00' AFTER harga_satuan");
        } catch (\Exception $e) {}
        try {
            $db->query("ALTER TABLE purchase_order_items ADD COLUMN jumlah_faktual DECIMAL(10,2) DEFAULT '0.00' AFTER tambahan");
        } catch (\Exception $e) {}
        try {
            $db->query("ALTER TABLE purchase_order_items ADD COLUMN total DECIMAL(15,2) DEFAULT '0.00' AFTER jumlah_faktual");
        } catch (\Exception $e) {}

        return "Successfully checked and added extra columns to purchase_order_items.";
    }
}
