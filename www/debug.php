<?php
echo "<pre>";
echo "coreInstall path: /var/www/api/\n";
echo "Exists: " . (is_dir('/var/www/api/') ? 'YES' : 'NO') . "\n";
echo "Exists ../api/: " . (is_dir('../api/') ? 'YES' : 'NO') . "\n";
echo "\nDirectory listing of /var/www/:\n";
print_r(scandir('/var/www/'));
echo "\nDirectory listing of /var/www/api/ (if exists):\n";
if(is_dir('/var/www/api/')) print_r(scandir('/var/www/api/'));
echo "\nsettings.php content:\n";
echo file_get_contents('/var/www/html/settings.php');
echo "</pre>";