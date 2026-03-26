<?php
// Quick check script - run: php public/check_users.php
require_once __DIR__ . '/../vendor/autoload.php';

$app = \Config\Services::codeigniter();
$app->initialize();

$db = \Config\Database::connect();
$users = $db->table('users')->select('id, username, role, sppg_id')->get()->getResultArray();

echo "=== USER ACCOUNTS ===\n";
echo str_pad("ID", 5) . str_pad("USERNAME", 30) . str_pad("ROLE", 15) . "SPPG_ID\n";
echo str_repeat("-", 60) . "\n";
foreach ($users as $u) {
    echo str_pad($u['id'], 5) . str_pad($u['username'], 30) . str_pad($u['role'], 15) . ($u['sppg_id'] ?? 'NULL') . "\n";
}
