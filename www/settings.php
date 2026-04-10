<?php
global $config;

$config['db']['name'] = getenv('CRLIBRE_API_HACIENDA_DB_NAME');
$config['db']['pwd']  = getenv('CRLIBRE_API_HACIENDA_DB_PASSWORD');
$config['db']['user'] = getenv('CRLIBRE_API_HACIENDA_DB_USER');
$config['db']['host'] = getenv('CRLIBRE_API_HACIENDA_DB_HOST');

$config['crypto']['key'] = getenv('CRLIBRE_API_HACIENDA_CRYPTO_KEY') ?: 'default-crypto-key-change-me';

$config['boot']['alert'] = "false";

$config['debug']['print_all']    = true;
$config['debug']['print_absurd'] = true;
$config['debug']['print_debug']  = true;
$config['debug']['print_error']  = true;

$config['mail']['type']     = "mail";
$config['mail']['address']  = "";
$config['mail']['noreply']  = "";
$config['mail']['host']     = "";
$config['mail']['username'] = "";
$config['mail']['password'] = "";
$config['mail']['secure']   = "tls";
$config['mail']['port']     = 587;

$config['modules']['coreInstall'] = "/var/www/api/";

$config['core']['siteName'] = 'BarberiaApp';
$config['core']['host']     = "apihacienda-production.up.railway.app";

$config['users']['sessionLifetime'] = -1;

$config['modules']['core']     = array('cala','db', 'users', 'files', 'geoloc', 'wirez', 'crypto');
$config['modules']['coreLoad'] = array('cala', 'db', 'users', 'crypto');

$config['modules']['corePath']    = $config['modules']['coreInstall'] . "modules/";
$config['modules']['contribPath'] = $config['modules']['coreInstall'] . "contrib/";
$config['core']['resourcesPath']  = $config['modules']['coreInstall'] . 'resources/';
$config['files']['basePath']      = $config['modules']['coreInstall'] . 'files/';