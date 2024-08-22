<?php
$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . "/include/controller/class/class.top.php";
$top = new top_of_page();
session_destroy();

//destory cookie
if (isset($_COOKIE['xyz'])) {
  unset($_COOKIE['xyz']);
  setcookie('xyz', null, -1, '/');
}

redirect("/");
?>