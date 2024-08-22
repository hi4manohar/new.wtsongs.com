<?php

session_start();

$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . '/include/controller/db/DBConfig.php';
require_once $rootDir . '/include/controller/common/common_class.php';
$common = new commonClass();
require_once $rootDir . '/include/controller/class/class.generic.php';
$generic = new generic_class();

function isexist_p_t($stt, $sta) {

  $checkExistSql = mysqli_query( $GLOBALS['link'], "SELECT * FROM wt_tracks WHERE track_title='$stt'" );
  if( mysqli_num_rows($checkExistSql) > 0 ) {
    return true;
  }

}

if(isset($_POST['stt']) && isset($_POST['sta']) && isset($_POST['stu']) ) {

  if( isexist_p_t($_POST['stt'], $_POST['sta']) ) {

    $s_data = array(
      'data_title' => $_POST['stt'],
      'data_album' => $_POST['sta'],
      'data_url' => $generic->get_url_type_string($_POST['stu']),
      'data_img' => $generic->get_images("album", $_POST['sta'], "_80x80"),
      'data_content' => "Listening to " . $_POST['stt'] . " song from album " . $_POST['sta'] . " on wtsongs.com"
    );

    require_once $rootDir . '/include/controller/common/sharepopup.php';
    echo "success";
  } else {
    echo "error";
  }

  
} elseif( isset($_POST['data']) && isset($_POST['data_url']) ) {

  $data = $_POST['data'];
  //check for album or playlist
  if( strpos($data, 'playlist') !== false ) {
    $plId = filter_var($data, FILTER_SANITIZE_NUMBER_INT);

    if( $common->is_pl_exist($plId) ) {
      $plDetail = $common->datadetail( array( "wt_playlists", "playlist_id", $plId ) );

      $s_data = array(
        'data_title' => $plDetail[0]['playlist_title'][0],
        'data_url' => $generic->get_url_type_string($_POST['data_url']),
        'data_img' => $generic->get_images("playlist", $plDetail[0]['playlist_title'][0], "_80x80"),
        'data_content' => "Listening to " . $plDetail[0]['playlist_title'][0] . " playlist on wtsongs.com"
      );

      require_once $rootDir . '/include/controller/common/sharepopup.php';
      echo "success";

    } else {
      echo "playlist could't found";
    }
  } elseif( strpos($data, 'album') !== false ) {
    $trimmedal = substr($data, 5);
    if( $common->is_al_exist($trimmedal) ) {
      if( list( $aldetail ) = $common->datadetail( array('wt_albums', 'album_id', $trimmedal) ) ){

        $s_data = array(
          'data_title' => $aldetail['album_title'][0],
          'data_url' => $generic->get_url_type_string($_POST['data_url']),
          'data_img' => $generic->get_images("album", $aldetail['album_title'][0], "_80x80"),
          'data_content' => "Listening to " . $aldetail['album_title'][0] . " album on wtsongs.com"
        );

        require_once $rootDir . '/include/controller/common/sharepopup.php';
        echo "success";

      } else echo "error";
    }
  } elseif( strpos($data, 'artist') !== false ) {
    $trimmedar = substr($data, 6);
    if( strlen($trimmedar) > 2 ){

      $s_data = array(
        'data_title' => $trimmedar,
        'data_url' => $generic->get_url_type_string($_POST['data_url']),
        'data_img' => "http://img.wtsongs.com/images/static/song_default_80x80.jpg",
        'data_content' => "Listening to " . $trimmedar . " artist songs on wtsongs.com"
      );

      require_once $rootDir . '/include/controller/common/sharepopup.php';
      echo "success";
      
    } else echo "error";
  }
} else {
  echo "error";
}


?>