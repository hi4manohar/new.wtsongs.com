<?php

$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . "/include/controller/class/class.top.php";
$top = new top_of_page();
require_once $rootDir . '/include/controller/db/DBConfig.php';

if( isset($_POST['do']) && $_POST['do'] == "getlogged_header" ) {
  if( logged_in ) {
    include $rootDir . '/include/controller/common/loggedincontent.php';
    if( class_exists('loggedincontent') ) {
      $logged = new loggedinContent();
      $logged->topHeaderLogin();
    } else {
    }
  }  
}

?>