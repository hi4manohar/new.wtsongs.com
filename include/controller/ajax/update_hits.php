<?php
session_start();

$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . '/include/controller/db/DBConfig.php';
require_once $rootDir . '/include/controller/common/common_class.php';

$common = new commonClass();

function defaultPlCookie() {
  if( !isset($_COOKIE['playedArr']) ) {
    setcookie( 'playedArr', '0', $time, "/" );
  }
}

function withoutSourceCookie( $track_id, $total_cookie, $time, $song_id ) {
  $playedArr = $_COOKIE['playedArr']+1;
  if( $total_cookie > 49 && $playedArr < 50 ) {
    $song_id = 'song_id[' . $playedArr . ']';
    //set current stored array song number
    setcookie( $song_id, $track_id, $time, "/" );
    setcookie( 'playedArr', $playedArr, $time, "/" );
  } else {
    if( $total_cookie > 49 ) {
      $song_id = 'song_id[0]';
    }
    setcookie( 'playedArr', '0', $time, "/" );
    setcookie( $song_id, $track_id, $time, "/" );
  }

  if( isset($_POST['source']) ) {
    echo "success";
  }
}

function trackUpdate($data, $common) {

  //check if track exist
  if( $common->is_track_exist($data) ) {

    $t_play_hits_sql = "SELECT play_hits FROM wt_tracks WHERE track_id='" . $data . "'";
    $t_play_hits_result = mysqli_query( $GLOBALS['link'], $t_play_hits_sql );
    if( mysqli_num_rows( $t_play_hits_result ) > 0 ) {
      while( $hits_row = mysqli_fetch_assoc( $t_play_hits_result ) ) {
        $totalHits[] = $hits_row['play_hits'];
      }
      $update_hits = $totalHits[0] + 1;
      $updateSql = "UPDATE wt_tracks SET play_hits='" . $update_hits . "' WHERE track_id='" . $data . "'";
      if( mysqli_query( $GLOBALS['link'], $updateSql ) ) {
        echo "success";
      } else {
        echo "failed" . mysqli_error($link);
      }
    }
  } else echo "track does't exist";
}

if(isset($_GET['track_id'])) {
  $trackId = $_GET['track_id'];

  if( is_numeric($trackId) ) {
    trackUpdate( $trackId, $common );
  }  
}

if( isset($_POST['data']) && isset($_POST['tag']) == "addtoqe" ) {
  $track_id = $_POST['data'];
  $time = time() + (86400 * 30);

  if( !isset($_COOKIE['song_id'][0]) ) {
    setcookie('song_id[0]', $track_id, $time, "/");
    defaultPlCookie();
    
  } else {
    $total_cookie = count( $_COOKIE['song_id'] );
    $song_id = 'song_id[' . $total_cookie . ']';

    if( in_array($track_id, $_COOKIE['song_id']) ) {
      echo "track exist";
    } else {
      withoutSourceCookie( $track_id, $total_cookie, $time, $song_id );
    }
    
  }
}

if( isset($_POST['tag']) ) {
  if( $_POST['tag'] == "clearqe" ) {
    foreach ($_COOKIE['song_id'] as $key => $value) {
      setcookie( 'song_id[' . $key . ']', "" );
      unset($_COOKIE['song_id'][$key]);
    }
    echo "qeCleared";
  }
  
}


?>