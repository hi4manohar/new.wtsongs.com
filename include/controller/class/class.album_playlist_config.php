<?php

class album_config {

  //function for checking query parameter
  function check_query($common_class) {

    $this->common_class = $common_class;

    if(isset($_GET['name']) || isset($_GET['song'])) {
      if( isset($_GET['song']) ) {
        $song = $common_class->testitle( $_GET['song'] );
        //check if download is requested
        if( isset($_GET['al']) ) {
          if( $this->download_handle($song) ) {
            return true;
          } else return false;
        } else {
          //check if song exist
          if( $common_class->is_track_exist($song) ) {
            $album_title = $common_class->execute_query("SELECT album_title FROM wt_albums as al, wt_tracks as wt WHERE wt.track_title='" . $song . "' AND al.album_id=wt.album_id LIMIT 1");
            if( mysqli_num_rows($album_title) == 1 ) {
              $album_title = mysqli_fetch_assoc($album_title);
              define('alTitle', $album_title['album_title']);
              define('alHeadTitle', $song . " Song");
              define('song', true);
              return true;
            } else return false;
          } else return false;
        }
      } else {
        define('alTitle', $_GET['name']);
        define('alHeadTitle', $_GET['name']);
        define('album', true);
        return true;
      }
    } else return false;
  }

  function download_handle($song) {
    $album = $_GET['al'];
    if( $this->common_class->is_al_exist($album) ) {
      //surety of album and tracks
      $data_result = $this->common_class->execute_query("SELECT t.track_id, al.album_id FROM wt_albums as al, wt_tracks as t WHERE al.album_title='" . $album . "' AND t.track_title='" . $song . "' AND al.album_id=t.album_id LIMIT 1");
      if( mysqli_num_rows($data_result) == 1 ) {
        $album_title = mysqli_fetch_assoc($data_result);
        define('alTitle', $album);
        define('alHeadTitle', $song . " Song");
        define('song', true);
        define('download', true);
        define('track_id', $album_title['track_id']);
        return true;
      } else return false;
    } else return false;
  }
}


?>