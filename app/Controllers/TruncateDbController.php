<?php

namespace App\Controllers;

class TruncateDbController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Mematikan foreign key check sementara agar truncate tidak error jika ada relasi
        $db->query('SET FOREIGN_KEY_CHECKS=0');
        
        $tables = $db->listTables();
        $exclude = ['users', 'migrations']; // tabel yang dilarang dihapus isinya
        $truncated = [];

        foreach ($tables as $table) {
            if (!in_array($table, $exclude)) {
                $db->query('TRUNCATE TABLE ' . $db->escapeIdentifiers($table));
                $truncated[] = $table;
            }
        }
        
        // Menghidupkan kembali foreign key check
        $db->query('SET FOREIGN_KEY_CHECKS=1');
        
        echo "Berhasil menghapus (truncate) isi tabel berikut:\n";
        foreach ($truncated as $t) {
            echo "- $t\n";
        }
        echo "\nTabel 'users' dan 'migrations' aman (tidak dihapus).";
    }
}
