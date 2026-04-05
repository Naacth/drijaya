<?php
namespace App\Controllers;
use CodeIgniter\Controller;
class UpdateDbController extends Controller {
    public function index() {
        $db = \Config\Database::connect();
        $forge = \Config\Database::forge();
        
        $fields = [
            'nama_aslap' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'nama_kepala_sppg' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'nama_ahli_gizi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'nama_kepala_koki' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'nama_akuntan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true]
        ];

        try {
            foreach ($fields as $fieldName => $fieldProps) {
                if (!$db->fieldExists($fieldName, 'user_signatures')) {
                    $forge->addColumn('user_signatures', [
                        $fieldName => $fieldProps
                    ]);
                    echo "Added column: $fieldName<br>";
                } else {
                    echo "Column $fieldName already exists.<br>";
                }
            }
            echo "Database update completed successfully.";
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
