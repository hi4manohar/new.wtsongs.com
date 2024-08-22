<?php
if( isset($_POST['reloadContent']) ) {
  include $_SERVER['DOCUMENT_ROOT'] . '/include/controller/ajax/user/user_playlist_update.php';
}

class userMainContent {

  public $user_name;
  public $user_id;
  public $user_email;
  public $total_track;
  public $start;
  public $limit;
  public $next;
  public $cat;

  public function userBody($cat) {
    $this->cat = $cat;
    $this->limit = 12;
    $page = (int) (!isset($_GET['page'])) ? 1 : $_GET['page'];
    $this->start = ($page * $this->limit) - $this->limit;
    $this->next = ++$page;
    $this->user_name = $_SESSION['user_name'];
    $this->user_id = $_SESSION['user_id'];
    $this->user_email = $_SESSION['user_email'];
    $this->show_create_pl = true;
    $this->show_image_uploader = true;
    /* call headpart of user */
    $this->userHead();
    if( $cat == $this->user_name ) $this->userBodyContent();
    if( $cat == "myalbums" || $cat == "myplaylists" || $cat == "myfavplaylists" ) $this->userAlbumBody();
    if( $cat == "mysettings" ) $this->mysettings();
  }

  function headerSql() {

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

    if( $userImg !== NULL ) {
      $user_img_data = array(
        'user_id' => user_id,
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

        $bd['img_array'][] = $this->generic->get_images( "album", $bd['album_title_with_year'][$key], "_175x175" );
      }

      unset( $imgArray, $imgArray2, $img );
      return array( $bd );
    }
  }

  function userPlaylistSql() {
    if( $this->cat == "myfavplaylists" ) {
      $bodySql = "SELECT pl.playlist_id, pl.playlist_title, u.firstname, u.unique_user_name FROM wt_playlists AS pl, wt_users AS u, wt_usermeta as um WHERE um.user_id='$this->user_id' AND um.term_id='9' AND um.object_id=pl.playlist_id AND u.id=pl.user_id ";
    } else {
      $bodySql = "SELECT pl.playlist_id, pl.playlist_title, u.firstname, u.unique_user_name FROM wt_playlists AS pl, wt_users AS u, wt_playlist_data AS pd WHERE pl.user_id='$this->user_id' AND pl.user_id=u.id GROUP BY pl.playlist_id LIMIT $this->start, $this->limit";
    }
    
    $bodyResult = mysqli_query( $GLOBALS['link'], $bodySql );
    if( mysqli_num_rows($bodyResult) > 0 ) {
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
      $bd['data_path_url'] = array( 'album' => "/playlists", 'artist' => "/user/" );

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

      foreach ($imgArray as $key => $value) {
        $bdLetter = substr($value, 0, 1);
        if(is_numeric($bdLetter)) {
          $bdLetter = "0-9";
        }
        $images = "http://img.wtsongs.com/images/albums/$bdLetter/" . $bd['album_img_with_year'][$key] . "/" . $imgArray[$key] . "_175x175.jpg";
          $images2 = "http://img.wtsongs.com/images/all/$bdLetter/" . $imgArray[$key] . ".jpg";
          $images3 = "http://img.wtsongs.com/images/all/$bdLetter/" . $imgArray2[$key] . ".jpg";
          if(@getimagesize($images)) {
            $img[] = $images;
          } elseif(@getimagesize($images2)) {
            $img[] = $images2;
          } elseif(@getimagesize($images3)) {
            $img[] = $images3;
          } else {
            $img[] = "http://img.wtsongs.com/images/static/song_default_175x175.jpg";
          }
        }

        $bd['img_array'] = array_map('strtolower', $img);

        unset( $imgArray, $imgArray2, $img, $album_url, $albumSql );

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
    <li><a href="/myhome/" title="My Songs" data-pjax="#main" class="<?php echo $this->user_name; ?>" data-push="true" data-target="#main">My Songs</a></li>
    <li><a href="myalbums" title="My Albums" data-pjax="#main" class="myalbums" data-push="true" data-target="#main">My Albums</a></li>
    <li><a href="myplaylists" title="My Playlist" data-pjax="#main" class="myplaylists" data-push="true" data-target="#main">My Playlist</a></li>
    <li><a href="myfavplaylists" title="My Favourite Playlist" data-pjax="#main" class="myfavplaylists" data-push="true" data-target="#main">My Fav. Playlists</a></li>
    <li><a href="mysettings" title="My Settings" data-pjax="#main" class="mysettings" data-push="true" data-target="#main">My Settings</a></li>
  </ul>
</div>

<?php
  }

  /*

  * calling user head part to show user_details

  */
  function userHead() {
    list( $hrData ) = $this->headerSql();
    include root_dir . "/include/main-content/content_fun/user_head.php";
  }
  function userBodyContent() {
    list( $bdData ) = $this->UserContentSql();
    if( !$bdData ) {
      $this->userNav();
    } else {
      include root_dir . "/include/main-content/content_fun/user_body_content.php";
    }

  }

  function userAlbumBody() {
    include root_dir . "/include/main-content/content_fun/user_album_body.php";
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