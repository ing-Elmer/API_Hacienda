<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Leer el api.php como texto y ejecutar línea por línea
$apiContent = file_get_contents('/var/www/html/api.php');
echo "api.php primeras 50 líneas:\n";
$lines = explode("\n", $apiContent);
for($i = 0; $i < 50; $i++) {
    echo ($i+1) . ": " . $lines[$i] . "\n";
}