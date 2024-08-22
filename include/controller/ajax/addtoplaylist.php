<?php
$rootDir =  $_SERVER['DOCUMENT_ROOT'];

//include coomontopfile
require_once $rootDir . '/include/controller/class/class.top.php';
$session_param = new top_of_page();
if( logged_in === true ) {
  $user_email = $_SESSION['user_email'];
  $user_id = $_SESSION['user_id'];
}

require_once $rootDir . '/include/controller/db/DBConfig.php';
require_once $rootDir . '/include/controller/common/loggedincontent.php';
require_once $rootDir . '/include/controller/common/common_class.php';

$common = new commonClass();

function addPlaylistToPlaylist( $data, $addin, $common ) {

  if( $common->is_pl_exist($data) ) {

    list( $allTrack ) = $common->getalltrackofplaylist($data);

    foreach ($allTrack as $key => $value) {
      if( $common->checkTrackExistinPlaylist( array($addin, $value) ) ) {
      } else {
        $insertTrack = mysqli_query( $GLOBALS['link'], "INSERT INTO wt_playlist_data (playlist_id, track_id) VALUES('$addin', '$value')" );
        if( $common->checkquery($insertTrack) ) {
        } else echo "cannot insert your song in playlist";
      }
    } echo "success";
  } else echo "playlist does not found";
}

//add track and queue track to selected playlist
function addTrackToPlaylist( $data, $addin, $common ) {

  if( $common->is_pl_exist($addin) ) {
    if( $common->checkTrackExistinPlaylist( array($addin, $data) ) ) {
      echo "success";
    } else {
      $insertTrackinPlaylist = mysqli_query( $GLOBALS['link'], "INSERT INTO wt_playlist_data (playlist_id, track_id) VALUES('$addin', '$data')" );
      if( $common->checkquery($insertTrackinPlaylist) ) {}
        else echo "cannot add song to playlist";

      echo "success";
    }
  } else echo "playlist does not exist";
}

function addAlbumToPlaylist( $data, $addin, $common ) {
  list( $allTrack ) = $common->datadetail( array('wt_tracks', 'album_id', $data) );
  $allTrackId = $allTrack['track_id'];

  foreach ($allTrackId as $key => $value) {
    if( $common->checkTrackExistinPlaylist( array($addin, $value) ) ) {
    } else {
      $insertTrack = mysqli_query( $GLOBALS['link'], "INSERT INTO wt_playlist_data (playlist_id, track_id) VALUES('$addin', '$value')" );
      if( $common->checkquery($insertTrack) ) {
      } else echo "cannot insert your song in playlist";
    }
  } echo "success";
}

if( isset($_POST['data']) ) {
  $data = $_POST['data'];
  if( strpos($data, 'playlist') !== false ) {
    $trimmedpl = substr($data, 8);
    if( $common->is_pl_exist( $trimmedpl ) ) {
      $obj = new createplaylistpopup();
      $obj->createplaylist();
    } else {
      echo "error";
    }
  } elseif( strpos($data, 'album') !== false ) {
    $trimmedal = substr($data, 5);

    if( $common->is_al_exist($trimmedal) ) {
      $obj = new createplaylistpopup();
      $obj->createplaylist();
    } else echo "error";
  } elseif( strpos($data, 'song') !== false ) {
    $trimmedtrack = substr($data, 4);
    if( $common->is_track_exist($trimmedtrack) ) {
      $obj = new createplaylistpopup();
      $obj->createplaylist();
    } else {
      echo "track does not exist";
    }
  } elseif( $data == "saveQe" ) {
    $obj = new createplaylistpopup();
    $obj->createplaylist();
  }
}

if( isset($_POST['aitpl']) && isset($_POST['atpl']) ) {

  //define in which playlist will be add
  $addpl[0] = $_POST['aitpl'];
  //define what playlist will be add
  $addpl[1] = $_POST['atpl'];

  if( strpos($addpl[1], 'album') !== false ) {

    $trimmedal = substr($addpl[1], 5);
    if( $common->is_al_exist($trimmedal) ) {

      $addinpl = $common->getplid($addpl[0]);
      addAlbumToPlaylist( $trimmedal, $addinpl, $common );
    }

  } elseif( strpos($addpl[1], 'playlist') !== false ) {
    $trimmedpl = substr($addpl[1], 8);
    $addinpl = $common->getplid($addpl[0]);
    addPlaylistToPlaylist( $trimmedpl, $addinpl, $common );

  } elseif( strpos($addpl[1], 'song') !== false ) {
    $trimmedtrack = substr($addpl[1], 4);
    if( $common->is_track_exist($trimmedtrack) ) {
      $addinpl = $common->getplid($addpl[0]);
      addTrackToPlaylist( $trimmedtrack, $addinpl, $common );
    }
  } elseif( $addpl[1] === "addqe" ) {
    $qe_tracks = $_POST['qedata'];
    $qe_tracks = substr($qe_tracks, 0, -1);
    $qe_tracks_arr = explode(',', $qe_tracks);
    $addinpl = $common->getplid($addpl[0]);
    foreach ($qe_tracks_arr as $key => $value) {
      addTrackToPlaylist( $value, $addinpl, $common );
    }
  } else echo "Not Found";

}

function createpl($ptitle, $preleased, $common) {
  $ptitle = $common->testitle($ptitle);
  $preleased = $preleased;

  $user_id = $GLOBALS['user_id'];

  //check if playlist is aleready create by user
  $checktitle = mysqli_query( $GLOBALS['link'], "SELECT * FROM wt_playlists where playlist_title='$ptitle' AND user_id='$user_id'" );
  if( mysqli_num_rows($checktitle) > 0 ) {
    echo "exist";
  } else {
    if( $common->createPlaylist($ptitle, $preleased) ) {
      return true;
    }
  }
}

if(isset($_POST['pltitle']) && isset($_POST['ischecked'])) {
  $ptitle = $_POST['pltitle'];
  $preleased = $_POST['ischecked'];
  if(createpl($ptitle, $preleased, $common)) {
    echo "success";
  } else {
    echo "playlist could not be created";
  }
}

if( isset($_POST['delpl']) ) {
  $delpl = $_POST['delpl'];
  if( strpos($delpl, 'playlist') !== false ) {
    $trimmedpl = substr($delpl, 8);
      //check if playlist is aleready create by user
    $checktitle = mysqli_query( $GLOBALS['link'], "SELECT * FROM wt_playlists where playlist_id='$trimmedpl' AND user_id='$user_id'" );
    if( mysqli_num_rows($checktitle) > 0 ) {
      if( $common->deleteNormalData( array('wt_playlists', 'playlist_id', $trimmedpl) ) ) {
        if( $common->deleteNormalData( array('wt_playlist_data', 'playlist_id', $trimmedpl) ) ) {
          echo "success";
        } else echo "track could not be deleted";
        
      } else echo "playlist could't deleted";      
    } else echo "playlist does not exist";
  } else echo "playlist data is not correct";
}

if( isset($_POST['plName']) && $_POST['updatepl'] && $_POST['trackid'] ) {
  $new_pl_title = $_POST['plName'];
  $update_to_id = $_POST['updatepl'];
  $remove_track_id = $_POST['trackid'];

  $trimmed_new_pl = $common->testitle($new_pl_title);
  if( $common->is_pl_exist($update_to_id) ) {
    if( $common->checkTrackExistinPlaylist( array( $update_to_id, $remove_track_id ) ) ) {
      
      if( $common->query_execute( "DELETE pd.* FROM wt_playlist_data pd INNER JOIN wt_playlists pl ON pl.playlist_id=pd.playlist_id AND pl.user_id='" . $user_id . "' WHERE pd.playlist_id='" . $update_to_id . "' AND pd.track_id='" . $remove_track_id . "'" ) ) {
        echo "success";
      } else {
        echo "track could't be deleted";
      }
    } else echo "track does not exist in playlist";
  } else echo "playlist does not exist";
}

if( isset($_POST['updateplname']) && isset($_POST['ispublic']) && isset($_POST['updatepl']) ) {
  
  $updateplname = $_POST['updateplname'];
  $ispublic = $_POST['ispublic'];
  $updateplid = $_POST['updatepl'];

  $trimmed_new_pl = $common->testitle($updateplname);
  if( $common->is_pl_exist($updateplid) ) {
    if( $common->query_execute( "UPDATE wt_playlists SET playlist_title='" . $trimmed_new_pl . "', released='" . $ispublic . "' WHERE playlist_id='" . $updateplid . "' AND user_id='" . $user_id . "'" ) ) {
      echo "true";
    } else echo "playlist could't updated";
  } else echo "playlist does't exist";

}

?>