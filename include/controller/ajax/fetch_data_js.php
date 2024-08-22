<?php
$rootDir =  $_SERVER['DOCUMENT_ROOT'];

require_once $rootDir . '/include/controller/class/class.top.php';
$session_param = new top_of_page();

require_once $rootDir . '/include/controller/db/DBConfig.php';
require_once $rootDir . '/include/controller/common/common_class.php';
$common = new commonClass();

if( isset($_POST['do']) && $_POST['do'] == "getsong" && isset($_POST['songid']) && $_POST['songid'] !== "") {
  if( logged_in === true ) {
    $song_id = $_POST['songid'];
    if( $common->is_track_exist($song_id) ) {
      $song_title = $common->execute_query( "SELECT t.track_title, al.album_title FROM wt_tracks as t, wt_albums as al WHERE t.track_id=$song_id AND t.album_id=al.album_id " );
      if( mysqli_num_rows($song_title) == 1 ) {
        $song_title = mysqli_fetch_assoc($song_title);
        $output['status'] = true;
        $output['song_title'] = strtolower( str_replace(' ', '+', $song_title['track_title'] ) );
        $output['song_album'] = strtolower( str_replace(' ', '+', $song_title['album_title'] ) );
      } else $output['error'] = "Sorry! song isn't exist";
    } else $output['error'] = "Sorry! song isn't exist";
  } else $output['error'] = "To download the song! \n you must have to login!";
  echo json_encode($output);
}

?>