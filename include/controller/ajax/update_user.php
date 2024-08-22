<?php
session_start();
$user_email = $_SESSION['user_email'];
$user_id = $_SESSION['user_id'];

$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . '/include/controller/db/DBConfig.php';
require_once $rootDir . '/include/controller/common/common_class.php';

//add favourite data
if( isset($_POST['favdata']) ) {
  $common = new commonClass();
  $favdata = $_POST['favdata'];
  //check is it album playlist or track
  if( strpos($favdata, 'playlist') !== false ) {
    $trimmedpl = substr($favdata, 8);
    if( $common->is_pl_exist($trimmedpl) ) {
      if( $common->addtofavpl( array('9', $trimmedpl) ) ) {
        echo "success";
      } else echo "deleted";
    }
  } elseif( strpos($favdata, 'album') !== false ) {
    $trimmedal = substr($favdata, 5);
    if( $common->is_al_exist($trimmedal) ) {
      if( $common->addtofavpl( array('27', $trimmedal) ) ) {
        echo "success";
      } else echo "deleted";
    }
  } elseif( strpos($favdata, 'song') !== false ) {
    $trimmedsong = substr($favdata, 4);
    if( $common->is_track_exist($trimmedsong) ) {
      if( $common->addtofavpl( array('28', $trimmedsong) ) ) {
        echo "success";
      } else echo "deleted";
    }
  }
}

?>