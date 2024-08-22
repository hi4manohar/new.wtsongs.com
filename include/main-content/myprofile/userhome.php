<?php

class userMainContent extends commonClass {

  public $user_name;
  public $user_id;
  public $user_email;
  public $total_track;
  public $start;
  public $limit;
  public $next;
  public $cat;

  public function userBody($cat) {
    global $user_data_show;
    $this->cat = $cat;
    $this->limit = 12;
    $page = (int) (!isset($_GET['page'])) ? 1 : $_GET['page'];
    $this->start = ($page * $this->limit) - $this->limit;
    $this->next = ++$page;
    $this->user_name = $user_data_show[0]['firstname'];
    $this->user_id = $user_data_show[0]['id'];
    $this->unique_user_name = $user_data_show[0]['unique_user_name'];
    $this->show_create_pl = false;
    $this->show_songs = ( $user_data_show['f_song'] == "checked" ) ? true : false;
    $this->show_albums = ( $user_data_show['fav_album'] == "checked" ) ? true : false;
    $this->show_fav_pl = ( $user_data_show['fav_playlist'] == "checked" ) ? true : false;
    $this->show_playlists = true;
    $this->show_image_uploader = false;
    $this->user_email = ( $user_data_show['email_pub'] == "checked" ) ? $user_data_show[0]['email'] : "Not Available";
    $this->userHead();
    if( $cat == "mysongs" ) $this->userBodyContent();
    if( $cat == "myalbums" ) $this->userAlbumBody("show_albums");
    if( $cat == "myplaylists" ) $this->userAlbumBody("show_playlists");
    if( $cat == "myfavplaylists" ) $this->userAlbumBody("show_fav_pl");
    //if( $cat == "mysettings" ) $this->mysettings();
  }

  function headerSql() {

    global $user_data_show;

    $headerResult = mysqli_query( $GLOBALS['link'], "SELECT 
    (SELECT COUNT(*) FROM wt_usermeta as u WHERE u.term_id='28' AND u.user_id='$this->user_id') as tt,
    (SELECT COUNT(*) FROM wt_usermeta as u WHERE u.term_id='27' AND u.user_id='$this->user_id') as ta,
    (SELECT COUNT(*) FROM wt_usermeta as u WHERE u.term_id='9' AND u.user_id='$this->user_id' ) as tp,
    (SELECT COUNT(*) FROM wt_playlists as pl WHERE pl.user_id='$this->user_id') as cp,
    (SELECT object_id FROM wt_usermeta as u WHERE u.user_id='$this->user_id' AND u.term_id='29') as ui
FROM wt_usermeta as u LIMIT 1" );

    if( mysqli_num_rows( $headerResult ) > 0 ) {
      $headerResult = mysqli_fetch_assoc( $headerResult );
      $hr['total_track'] = $headerResult['tt'];
      $this->total_track = $hr['total_track'];
      $hr['total_album'] = $headerResult['ta'];
      $hr['total_pl'] = $headerResult['tp'];
      $hr['created_pl'] = $headerResult['cp'];
      $userImg = $headerResult['ui'];
    } else goto_errorpage();

    $this->generic = $this->set_generic();

    if( $userImg !== NULL && $user_data_show['p_pic'] == "checked" ) {

      $user_img_data = array(
        'user_id' => $this->user_id,
        'img_name' => $userImg
      );

      /* call to generic class for user_img_data */

      $hr['user_image'] = $this->generic->get_images( "user", $user_img_data, "" );
    } else $hr['user_image'] = "/assets/img/default_user.jpg";

    return array( $hr );
  }

  function UserContentSql() {
    $bodySql = "SELECT u.object_id, t.track_title, t.album_id, t.artist_name, t.play_hits, al.album_title, l.lang_title FROM `wt_usermeta` AS u, `wt_tracks` t, `wt_albums` as al, wt_lang as l WHERE u.term_id='28' AND u.user_id='$this->user_id' AND u.object_id=t.track_id AND t.album_id=al.album_id AND l.lang_id=al.lang_id LIMIT $this->start, $this->limit";
    $bodyResult = mysqli_query( $GLOBALS['link'], $bodySql );
    if( mysqli_num_rows( $bodyResult ) > 0 ) {
      while ( $bdRow = mysqli_fetch_assoc($bodyResult) ) {
        $bd['track_id'][] = $bdRow['object_id'];
        $bd['track_title'][] = $bdRow['track_title'];
        $bd['artist_name'][] = $bdRow['artist_name'];
        $bd['album_title'][] = $bdRow['album_title'];
        $bd['album_id'][] = $bdRow['album_id'];
        $bd['track_playhits'][] = $bdRow['play_hits'];
        $bd['lang_title'][] = $bdRow['lang_title'];
        if( is_numeric( substr($bdRow['album_title'], -4) ) ) {
          $bd['album_name_without_year'][] = substr($bdRow['album_title'], 0, -5);
        } else $bd['album_name_without_year'][] = $bdRow['album_title'];
      }

      $bd['total_track'] = $this->total_track;
      $bd['t_title'] = str_replace(' ', '+', $bd['track_title']);
      $bd['track_title_url'] = array_map('strtolower', $bd['t_title']);
      $bd['a_title'] = str_replace(' ', '+', $bd['album_title']);
      $bd['album_title_url'] = array_map('strtolower', $bd['a_title']);
      unset( $bd['t_title'], $bd['a_title'] );
      return array( $bd );
    }
  }

  function userAlbumSql() {
    $bodySql = "SELECT u.object_id, al.album_id, al.album_title, t.artist_name FROM wt_usermeta as u, wt_albums as al, wt_tracks as t WHERE u.user_id='$this->user_id' AND u.term_id='27' AND al.album_id=u.object_id AND t.album_id=u.object_id GROUP BY u.object_id LIMIT $this->start, $this->limit";
    $bodyResult = mysqli_query( $GLOBALS['link'], $bodySql );
    if( mysqli_num_rows($bodyResult) > 0 ) {
      while( $bdRow = mysqli_fetch_assoc($bodyResult) ) {
        $bd['album_id'][] = $bdRow['album_id'];
          $albumYearCheck = substr($bdRow['album_title'], -4);

          if( is_numeric($albumYearCheck) ) {
            $bd['album_title_without_year'][] = substr( $bdRow['album_title'], 0, -5 );
          } else $bd['album_title_without_year'][] = $bdRow['album_title'];

          $bd['album_title_with_year'][] = $bdRow['album_title'];
          $bd['album_artist'][] = $bdRow['artist_name'];
      }

      $imgArray = str_replace(' ', '+', $bd['album_title_with_year']);
      $imgArray2 = str_replace(' ', '+', $bd['album_title_without_year']);
      $bd['album_url'] = array_map('strtolower', $imgArray);
      $bd['data_path_url'] = array( 'album' => "/album/", 'artist' => "/artist/" );

      $this->generic = $this->set_generic();

      foreach ($imgArray as $key => $value) {

        $bd['img_array'] = $this->generic->get_images( "album", $bd['album_title_with_year'][$key], "_175x175" );
      }

      unset( $imgArray, $imgArray2, $img );
      return array( $bd );
    }
  }

  function userPlaylistSql() {
    if( $this->cat == "myfavplaylists" ) {
      $bodySql = "SELECT pl.playlist_id, pl.playlist_title, u.firstname, u.unique_user_name FROM wt_playlists AS pl, wt_users AS u, wt_usermeta as um WHERE um.user_id='$this->user_id' AND um.term_id='9' AND um.object_id=pl.playlist_id AND u.id=pl.user_id ";
    } else {
      $bodySql = "SELECT pl.playlist_id, pl.playlist_title, u.firstname, u.unique_user_name FROM wt_playlists AS pl, wt_users AS u, wt_playlist_data AS pd WHERE pl.user_id='$this->user_id' AND pl.user_id=u.id AND pl.released='1' GROUP BY pl.playlist_id LIMIT $this->start, $this->limit";
    }
    
    $bodyResult = $this->execute_query( $bodySql );
    if( mysqli_num_rows($bodyResult) > 0 && $bodyResult !== false ) {
      while( $bdRow = mysqli_fetch_assoc($bodyResult) ) {
        $bd['album_id'][] = $bdRow['playlist_id'];
        $bd['album_title_without_year'][] = $bdRow['playlist_title'];
        $bd['album_title_with_year'][] = $bdRow['playlist_title'];
        $bd['album_artist'][] = $bdRow['firstname'];
        $bd['album_artist_unique'][] = $bdRow['unique_user_name'];
      }

      //if album belongs to user then album album_url
      $bd['album_artist_url'] = array_map('strtolower', str_replace(' ', '+', $bd['album_artist_unique']));

      $album_url = str_replace(' ', '+', $bd['album_title_without_year']);
      $bd['al_url'] = array_map('strtolower', $album_url);
      $bd['data_path_url'] = array( 'album' => "/playlists", 'artist' => "" );

      //image detection script
      foreach( $bd['album_id'] as $key=>$value ) {

        $albumSql = mysqli_query( $GLOBALS['link'], "SELECT al.album_title FROM wt_playlist_data AS pd, wt_tracks as t, wt_albums AS al WHERE pd.playlist_id='$value' AND t.track_id=pd.track_id AND t.album_id=al.album_id LIMIT 1 " );
        if( mysqli_num_rows($albumSql) > 0 ) {

          while( $bdRow = mysqli_fetch_assoc( $albumSql ) ) {

            $bd['album_img_with_year'][] = $bdRow['album_title'];
            $albumYearCheck = substr($bdRow['album_title'], -4);

            if( is_numeric($albumYearCheck) ) {
              $bd['album_img_without_year'][] = substr( $bdRow['album_title'], 0, -5 );
            } else $bd['album_img_without_year'][] = $bdRow['album_title'];
          }

        } else {
          $bd['album_img_with_year'][] = "";
          $bd['album_img_without_year'][] = "";
        }
        if( $bd['album_artist'][$key] == "wtsongs" )
          $bd['album_url'][] = "/" . $bd['al_url'][$key];
        else $bd['album_url'][] = "/" . $bd['album_artist_url'][$key] . "/" . $bd['al_url'][$key];
      }

      $imgArray = str_replace(' ', '+', $bd['album_img_with_year']);
      $imgArray2 = str_replace(' ', '+', $bd['album_img_without_year']);

      $this->generic = $this->set_generic();

      foreach ($imgArray as $key => $value) {

        $bd['img_array'][] = $this->generic->get_images( "album", $bd['album_img_with_year'][$key], "_175x175" );
      }

      unset( $imgArray, $imgArray2, $album_url, $albumSql );
      return array( $bd );
    }
  }

  function user_settings() {
    $user_detail = mysqli_query( $GLOBALS['link'], "SELECT firstname, lastname, unique_user_name, email FROM wt_users WHERE id='" . $this->user_id . "' AND email='" . $this->user_email . "'" );
    if( mysqli_num_rows( $user_detail ) == 1 ) {
      while( $udRow = mysqli_fetch_assoc( $user_detail ) ) {
        $ud['firstname'] = $udRow['firstname'];
        $ud['unique_user_name'] = $udRow['unique_user_name'];
        $ud['lastname'] = $udRow['lastname'];
        $ud['email'] = $udRow['email'];
      }

      //user config
      $user_config = mysqli_query( $GLOBALS['link'], "SELECT object_id FROM wt_usermeta WHERE user_id='" . $this->user_id . "' AND term_id BETWEEN 30 AND 34" );
      if( mysqli_num_rows( $user_config ) > 0 ) {
        while( $udRow = mysqli_fetch_assoc( $user_config ) ) {
          $ud['show_user'][] = $udRow['object_id'];
        }
      }
      //user email config
      $user_email_config = mysqli_query( $GLOBALS['link'], "SELECT object_id FROM wt_usermeta WHERE user_id='" . $this->user_id . "' AND term_id BETWEEN 35 AND 38" );
      if( mysqli_num_rows( $user_email_config ) > 0 ) {
        while( $udRow = mysqli_fetch_assoc($user_email_config) ) {
          $ud['email_config'][] = $udRow['object_id'];
        }
      }
      return array( $ud );
    }
  }

  function set_generic() {
    global $generic;
    return $generic;
  }

  function userNav() {

?>

<div class="nav">
  <ul>
    <li><a href="/user/<?php echo $this->unique_user_name; ?>/mysongs" title="<?php echo $this->user_name; ?> Songs" data-pjax="#main" data-push="true" data-target="#main" class="mysongs">My Songs</a></li>
    <li><a href="/user/<?php echo $this->unique_user_name; ?>/myalbums" title="<?php echo $this->user_name; ?> Albums" data-pjax="#main" data-push="true" data-target="#main" class="myalbums">My Albums</a></li>
    <li><a href="/user/<?php echo $this->unique_user_name; ?>/myplaylists" title="<?php echo $this->user_name; ?> Playlist" data-pjax="#main" data-push="true" data-target="#main" class="myplaylists">My Playlist</a></li>
    <li><a href="/user/<?php echo $this->unique_user_name; ?>/myfavplaylists" title="<?php echo $this->user_name; ?> Favourite Playlist" data-pjax="#main" data-push="true" data-target="#main" class="myfavplaylists">My Fav. Playlists</a></li>
  </ul>
</div>

<?php
  }

  function userHead() {
    list( $hrData ) = $this->headerSql();
    include root_dir . "/include/main-content/content_fun/user_head.php";
  }
  function userBodyContent() {
    list( $bdData ) = $this->UserContentSql();
    if( $this->show_songs === true && isset( $bdData ) )
      include root_dir . "/include/main-content/content_fun/user_body_content.php";
    else {
      $this->userNav();
      echo '<p class="seogiUI" style="padding: 35px 0px; font-size: 20px; color: rgb(153, 153, 153); float: left; text-align: center; width: 100%;">Sorry! user is\'t allowed to show his favourite songs.</p>';
    }
      
  }

  function userAlbumBody($show_albums) {
    if( $this->$show_albums === true )
      include root_dir . "/include/main-content/content_fun/user_album_body.php";
    else {
      $this->userNav();
      echo '<p class="seogiUI" style="padding: 35px 0px; font-size: 20px; color: rgb(153, 153, 153); float: left; text-align: center; width: 100%;">Sorry! user is\'t allowed to show his favourite albums.</p>';
    } 
  }

  //mysettings
  function mysettings() {
    $this->userNav();
    list( $udData ) = $this->user_settings();
    //user settings
    include root_dir . '/include/main-content/content_fun/user.settings.php';
  }
}

?>