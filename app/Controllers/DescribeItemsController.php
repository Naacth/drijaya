<?php

namespace App\Controllers;

class DescribeItemsController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $query = $db->query("DESCRIBe purchase_order_items");
        echo "<table>";
        foreach ($query->getResult() as $row) {
            echo "<tr><td>" . $row->Field . "</td><td>" . $row->Type . "</td></tr>";
        }
        echo "</table>";
    }
}
