<?php

class plTrackContainer {

  public $pLetter;
  public $pAlbumImg;
  public $img_name;
  public $pl_url;

  
  public function plDataDisplay() {
    $this->pl_url = strtolower( str_replace(' ', '+', plTitle) );

    if( defined('plediting') && plediting === true ) {
      $staus = $this->plEditHeader();
      $this->plTracks();
    } else {
      $this->plHeaderImage(plTitle);
      $staus = $this->plHeader();
      $this->plTracks();
    }    
  }

  public function user_based_query( $query_for ) {
    global $playlist;
    if( $query_for == "plHeaderSql" ) {
      if( activeEditDeletePl ):
        $tt_track = mysqli_query( $GLOBALS['link'], "SELECT pl.playlist_id, pl.playlist_title, (SELECT COUNT(*) FROM wt_playlist_data as pd WHERE pl.playlist_id=pd.playlist_id) as tt, (SELECT COUNT(*) FROM wt_usermeta as u WHERE u.object_id=pl.playlist_id AND u.term_id='9' AND is_fav='1') as tf, pl.creation_date, u.firstname, t.album_id, al.album_title FROM wt_playlists as pl, wt_playlist_data as pd, wt_users AS u, wt_tracks AS t, wt_albums AS al WHERE pl.playlist_id='" . $playlist['playlist_id'] . "' AND pl.user_id=u.id AND pl.playlist_id=pd.playlist_id AND pd.track_id=t.track_id AND al.album_id=t.album_id LIMIT 1" );
      else:
        $tt_track = mysqli_query( $GLOBALS['link'], "SELECT pl.playlist_id, pl.playlist_title, (SELECT COUNT(*) FROM wt_playlist_data as pd WHERE pl.playlist_id=pd.playlist_id) as tt, (SELECT COUNT(*) FROM wt_usermeta as u WHERE u.object_id=pl.playlist_id AND u.term_id='9' AND is_fav='1') as tf, pl.creation_date, u.firstname, t.album_id, al.album_title FROM wt_playlists as pl, wt_playlist_data as pd, wt_users AS u, wt_tracks AS t, wt_albums AS al WHERE pl.playlist_id='" . $playlist['playlist_id'] . "' AND pl.user_id=u.id AND pl.playlist_id=pd.playlist_id AND pd.track_id=t.track_id AND al.album_id=t.album_id LIMIT 1" );
      endif;
      return $tt_track;
    } elseif( $query_for == "plTrackSql" ) {
      if( activeEditDeletePl ):
        $pl_track_data = "SELECT wt.track_id, wt.track_title, wt.play_hits, al.album_id, al.album_title, wt.artist_name, lg.lang_title FROM wt_playlists as pl, wt_playlist_data as pd, wt_tracks as wt, wt_albums as al, wt_lang as lg WHERE pl.playlist_id='" . $playlist['playlist_id'] . "' AND pd.playlist_id=pl.playlist_id AND wt.track_id=pd.track_id AND al.album_id=wt.album_id AND al.lang_id=lg.lang_id AND user_id=" . user_id;
      else:
        $pl_track_data = "SELECT wt.track_id, wt.track_title, wt.play_hits, al.album_id, al.album_title, wt.artist_name, lg.lang_title FROM wt_playlists as pl, wt_playlist_data as pd, wt_tracks as wt, wt_albums as al, wt_lang as lg WHERE pl.playlist_id='" . $playlist['playlist_id'] . "' AND pd.playlist_id=pl.playlist_id AND wt.track_id=pd.track_id AND al.album_id=wt.album_id AND al.lang_id=lg.lang_id";
      endif;
      return $pl_track_data;
    }
  }

  public function plHeaderImage($plTitle) {

    $this->generic = $this->set_generic();
    $this->pAlbumImg = $this->generic->get_images( "playlist", $plTitle, "_175x175" );
  }

  public function userplHeaderImage($hTitle) {
    $this->generic = $this->set_generic();
    $this->pAlbumImg = $this->generic->get_images( "album", $hTitle, "_175x175" );
  }

  function plHeaderSql() {
    $tt_track = $this->user_based_query("plHeaderSql");
    if( !$tt_track ) goto_errorpage();
    elseif( mysqli_num_rows($tt_track) > 0 ) {
      //loot through data
      while( $t_track_data = mysqli_fetch_assoc($tt_track) ) {
        $header['total_track'] = $t_track_data['tt'];
        $header['created_on'] = $t_track_data['creation_date'];
        $header['playlist_id'] = $t_track_data['playlist_id'];
        $header['pl_user'] = $t_track_data['firstname'];
        $header['first_album_title'] = $t_track_data['album_title'];
        $header['tf'] = $t_track_data['tf'];
      }

      //update hits
      global $common;
      $hits_result = $common->update_a_or_pl_hits( $header['playlist_id'], "playlist" );
      if( $hits_result !== true ) {
        echo "cannot update hits";
      }

      if( $header['pl_user'] !== "wtsongs" ) $this->userplHeaderImage( $header['first_album_title'] );

      $header['total_fav'] = ( $header['tf'] > 0 ) ? $header['tf']: "Be First to Make it Favourites";

      unset($tt_track, $header['tf']);

      return array( $header );
    }

    elseif( empty($header['playlist_id']) ) {
      $plHeaderDetail = mysqli_query( $GLOBALS['link'], "SELECT pl.playlist_id, pl.playlist_title, pl.creation_date, u.firstname FROM wt_playlists as pl, wt_users AS u WHERE pl.playlist_title='" . plTitle . "' AND pl.user_id=u.id AND pl.user_id='" . user_id . "' LIMIT 1" );
      if( mysqli_num_rows($plHeaderDetail) > 0 ):
        $t_track_data = mysqli_fetch_assoc($plHeaderDetail);
        $header['created_on'] = $t_track_data['creation_date'];
        $header['playlist_id'] = $t_track_data['playlist_id'];
        $header['pl_user'] = $t_track_data['firstname'];
        $header['total_track'] = '0';

        $favSql = mysqli_query( $GLOBALS['link'], "SELECT * FROM wt_usermeta AS u WHERE u.object_id='" . $header['playlist_id'] . "' AND term_id='9' AND is_fav='1'" );
        $header['total_fav'] = ( !mysqli_num_rows( $favSql ) > 0 ) ? "Be First to Make it " : mysqli_num_rows( $favSql ) ;
        return array( $header );
      endif;
    } else goto_errorpage();
  }

  function plEditHeaderSql() {
    $ehSql = mysqli_query( $GLOBALS['link'], "SELECT pl.playlist_id, pl.playlist_title, pl.released, pl.creation_date, (SELECT COUNT(*) FROM wt_playlist_data as pd WHERE pl.playlist_id=pd.playlist_id) as tt FROM wt_playlists as pl WHERE pl.playlist_title='" . plTitle . "' AND pl.user_id='" . user_id . "' LIMIT 1" );
    if( mysqli_num_rows($ehSql) > 0 ) {
      $ehRow = mysqli_fetch_assoc($ehSql);
      $eh['pl_id'] = $ehRow['playlist_id'];
      $eh['released'] = $ehRow['released'];
      $eh['total_track'] = $ehRow['tt'];
      $eh['created_on'] = $ehRow['creation_date'];

      return array( $eh );
    }
  }

  function plTrackSql() {
    $pl_track_data = $this->user_based_query( "plTrackSql" );
    $pl_track_data_result = mysqli_query( $GLOBALS['link'], $pl_track_data );
    if( !$pl_track_data_result ): $goto_errorpage();
    elseif( mysqli_num_rows( $pl_track_data_result ) > 0 ):
    //loop through data
    while( $pl_track_row = mysqli_fetch_assoc($pl_track_data_result) ) {

      //new
      $pl['track_title'][] = $pl_track_row['track_title'];
      $pl['artist_name'][] = $pl_track_row['artist_name'];
      $plAlbumTitle = $pl_track_row['album_title'];
      $pl['album_name_with_year'][] = $plAlbumTitle;
      $pl['track_id'][] = $pl_track_row['track_id'];
      $pl['album_id'][] = $pl_track_row['album_id'];
      $pl['track_al_lang'][] = $pl_track_row['lang_title'];
      $pl['track_play_hits'][] = $pl_track_row['play_hits'];

      //check album year numeric
      if( is_numeric( substr($plAlbumTitle, -4) ) ) {
        $pl['album_name_without_year'][] = substr($plAlbumTitle, 0, -5);
      } else $pl['album_name_without_year'][] = $plAlbumTitle;
    }
    $pl['album_without_space'] = str_replace(' ', '+', $pl['album_name_with_year']);
    $pl['album_url'] = array_map('strtolower', $pl['album_without_space']);
    unset( $pl['album_without_space'] );

    $pl['song_url_arrange'] = str_replace(' ', '+', $pl['track_title']);
    $pl['song_url'] = array_map('strtolower', $pl['song_url_arrange']);

    $pl['track_album_img'] = str_replace(' ', '+', $pl['album_name_with_year']);
    return array( $pl );
    endif;
  }

  function set_generic() {
    global $generic;
    return $generic;
  }

  function plHeader() {
    global $playlist;
    require root_dir . "/include/main-content/content_fun/playlist_header.php";
    return $headerData['total_track'];

  }

  function plEditHeader() {
    global $playlist;
    list( $ehData ) = $this->plEditHeaderSql();
    require root_dir . "/include/main-content/content_fun/edit_playlist_header.php";

    return $ehData['total_track'];
  }

  function plTracks() {
    global $playlist;
    if( $playlist['track_detail'] === true )
      include root_dir . "/include/main-content/content_fun/playlist_song_container.php";
    else echo '<p class="seogiUI" style="padding: 35px 0px; font-size: 20px; color: rgb(153, 153, 153); float: left; text-align: center; width: 100%;">There is no song in this playlist.</p>';
  }
}

?>
