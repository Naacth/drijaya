<?php
$mysqli = new mysqli('localhost', 'root', '', 'sm');
$dir = 'app/Database/Migrations/';
$files = scandir($dir);

// Delete problematic records first
$mysqli->query("DELETE FROM migrations WHERE version LIKE '2026-03-24%' OR version LIKE '2026-03-28%'");
echo "Deleted " . $mysqli->affected_rows . " problematic records\n";

foreach ($files as $file) {
    if (preg_match('/^(\d{4}[-_]\d{2}[-_]\d{2}[-_]\d{6})_(.+)\.php$/', $file, $matches)) {
        $version = $matches[1];
        $filename = $matches[2];
        
        // Skip the Maintenance & Hygiene one so spark can run it and create tables
        if ($version === '2026-03-28-000012') continue;
        
        // Read the file to get the class name
        $content = file_get_contents($dir . $file);
        if (preg_match('/class\s+(\w+)\s+extends\s+Migration/i', $content, $m)) {
            $class = "App\\Database\\Migrations\\" . $m[1];
            $time = time();
            $batch = 1;
            
            $stmt = $mysqli->prepare("INSERT INTO migrations (version, class, `group`, namespace, time, batch) VALUES (?, ?, 'default', 'App', ?, ?)");
            $stmt->bind_param("ssii", $version, $class, $time, $batch);
            if ($stmt->execute()) {
                echo "Fixed $version ($class)\n";
            } else {
                echo "Error fixing $version: " . $mysqli->error . "\n";
            }
        }
    }
}
echo "Migration record synchronization complete.\n";
