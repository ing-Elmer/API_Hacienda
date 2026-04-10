<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

echo "PASO 1\n";

require_once('/var/www/html/settings.php');
echo "PASO 2 - settings OK\n";

echo "coreInstall: " . $config['modules']['coreInstall'] . "\n";
echo "corePath exists: " . (is_dir($config['modules']['corePath']) ? 'YES' : 'NO') . "\n";

echo "PASO 3\n";
require_once($config['modules']['corePath'] . 'cala/module.php');
echo "PASO 4 - cala OK\n";