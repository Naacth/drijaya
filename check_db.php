<?php
$db = new mysqli('localhost', 'root', 'Elaina870.', 'sm');
if ($db->connect_error) { echo 'FAIL'; exit; }

// Fix ALL non-admin users that still have NULL sppg_id
$db->query("UPDATE users SET sppg_id = 1 WHERE sppg_id IS NULL AND role != 'admin'");
echo "Fixed " . $db->affected_rows . " users\n";

// Verify
$r = $db->query("SELECT id, username, role, sppg_id FROM users WHERE sppg_id IS NULL");
echo "\nRemaining users with NULL sppg_id (should only be admin):\n";
while ($row = $r->fetch_assoc()) {
    echo "  ID={$row['id']} username={$row['username']} role={$row['role']}\n";
}
$db->close();
echo "Done!\n";
