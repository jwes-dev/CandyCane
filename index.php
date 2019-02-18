<?php
file_put_contents(".htaccess", "RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_URI}  !(\.png|\.jpg|\.gif|\.jpeg|\.bmp|\.js|\.css|\.eot|\.woff|\.ttf|\.svg)$
RewriteRule ^(.*)$ StartUp.php [NC,L,QSA]

#Alternate default index page
DirectoryIndex StartUp.php", FILE_APPEND);
header("location: Home/Index");
?>