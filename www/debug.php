<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Simular el request
$_POST['w'] = 'ejemplo';
$_POST['r'] = 'hola';
$_SERVER['CONTENT_TYPE'] = 'application/x-www-form-urlencoded';

ob_start();
include('/var/www/html/api.php');
$output = ob_get_clean();

echo "=== OUTPUT ===\n";
echo $output . "\n";
echo "=== ERRORS ===\n";
echo error_get_last() ? print_r(error_get_last(), true) : "None\n";