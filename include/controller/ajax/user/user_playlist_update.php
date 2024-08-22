<?php
$rootDir = $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . "/include/controller/class/class.top.php";
$top = new top_of_page();

$dataReload = $_POST['reloadContent'];
$contentArray = array( 'user_playlist', 'user_song' );
if( in_array($dataReload, $contentArray) ) {
  require_once $rootDir . '/include/controller/db/DBConfig.php';
  $drObj = new userMainContent();
  $drObj->cat = "myplaylists";
  $drObj->user_id = $_SESSION['user_id'];
  $drObj->start = 0;
  $drObj->limit = 12;
  $drObj->userAlbumBody();
}
?>