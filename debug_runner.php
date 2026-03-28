<?php
require 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';

$runner = \Config\Services::migrations();
$history = $runner->getHistory();

echo "Migration History according to Runner:\n";
foreach ($history as $migration) {
    echo "- Version: {$migration->version}, Class: {$migration->class}, Batch: {$migration->batch}\n";
}

$all = $runner->findMigrations();
echo "\nAll Migrations found in files:\n";
foreach ($all as $m) {
    echo "- Version: {$m->version}, Class: {$m->class}\n";
}
