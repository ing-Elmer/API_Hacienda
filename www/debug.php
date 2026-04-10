<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "PHP OK\n";

// Test DB connection
$host = getenv('CRLIBRE_API_HACIENDA_DB_HOST') ?: 'mysql.railway.internal';
$user = getenv('CRLIBRE_API_HACIENDA_DB_USER') ?: 'root';
$pass = getenv('CRLIBRE_API_HACIENDA_DB_PASSWORD') ?: '';
$db   = getenv('CRLIBRE_API_HACIENDA_DB_NAME') ?: 'railway';

echo "Connecting to: $host\n";

try {
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$db", $user, $pass);
    echo "DB Connection: OK\n";
} catch(Exception $e) {
    echo "DB Error: " . $e->getMessage() . "\n";
}

// Test include
echo "\nLoading api.php...\n";
ob_start();
include('/var/www/html/api.php');
$output = ob_get_clean();
echo "Output: " . $output . "\n";