<?php
file_put_contents(".htaccess", "RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_URI}  !(\.png|\.jpg|\.gif|\.jpeg|\.bmp|\.js|\.css|\.eot|\.woff|\.ttf|\.svg)$
RewriteRule ^(.*)$ StartUp.php [NC,L,QSA]
#Alternate default index page
DirectoryIndex StartUp.php", FILE_APPEND);

$AppPath =  "/".trim($_SERVER["REQUEST_URI"], "/install.php");
echo "Set your AppPath in the App.Config.json file as \"$AppPath\".";
?>