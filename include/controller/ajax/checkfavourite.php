<?php
session_start();

$user_email = $_SESSION['user_email'];
$user_id = $_SESSION['user_id'];

$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . '/include/controller/db/DBConfig.php';
require_once $rootDir . '/include/controller/common/common_class.php';

if( empty($user_id) && empty($user_email) ) {
  echo "failded";
} elseif(isset($_POST['jsontrackid'])) {
  if(isset($_POST['jsontrackid'])) {
    $jsontrackid = $_POST['jsontrackid'];
    //check track exist in favourite
    $trackExistance = mysqli_query( $link, "SELECT meta_id FROM wt_usermeta WHERE user_id='$user_id' AND object_id='$jsontrackid' AND term_id='28'" );
    if(mysqli_num_rows($trackExistance) > 0) {
      echo "success";
    } else {
      echo "failed";
    }
  } else {
    echo "failed";
  }
}

if( isset( $_POST['favdata'] ) ) {
  $favdata = $_POST['favdata'];
  $common = new commonClass();
  //check is it album or playlist
  if( strpos($favdata, 'album') !== false ) {
    $trimmedal = substr($favdata, 5);
    if( $common->checkFavOnloadAlbum($trimmedal, '27') ) {
      echo "success";
    }
  } elseif( strpos($favdata, 'playlist') !== false ) {
    $trimmedpl = substr($favdata, 8);
    if( $common->checkFavOnloadAlbum($trimmedpl, '9') ) {
      echo "success";
    }
  }  
}

?>