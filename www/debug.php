<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "PASO 1\n";
require_once('/var/www/html/settings.php');
echo "PASO 2 - settings OK\n";
echo "PASO 3\n";
require_once($config['modules']['corePath'] . 'cala/module.php');
echo "PASO 4 - cala OK\n";

// Simular POST request
$_POST['w'] = 'ejemplo';
$_POST['r'] = 'hola';

// Simular el input JSON que espera el API
$input = json_encode(['w' => 'ejemplo', 'r' => 'hola']);
file_put_contents('php://stdin', $input);

echo "PASO 5 - simulando request\n";

// Ver qué lee el api.php como input
$rawInput = file_get_contents('php://input');
echo "Raw input: " . $rawInput . "\n";

// Ver cómo procesa cala el request
echo "PASO 6\n";
$cala = new Cala();
echo "PASO 7 - Cala instanciado\n";
print_r($cala);