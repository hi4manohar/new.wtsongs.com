<?php
// ** MySQL settings - You can get this info from your web host ** //
define('DB_NAME', 'wtsongs');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$link) {
  echo 'Unable to connect to the database server.';
  exit();
}

if (!mysqli_set_charset($link, 'UTF8')) {
  echo 'Unable to set database connection encoding.';
  exit();
}

if(!mysqli_select_db($link, DB_NAME)) {
  echo 'Unable to locate database.';
  exit();  
}
?>