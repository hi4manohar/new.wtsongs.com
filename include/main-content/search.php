<?php

class searchContainer {

  public $cat;
  public $query;

  public function displaySearch($cat, $query) {

    $this->cat = $cat;
    $this->query = $query;
    $this->limit = ($cat == "songs") ? 10 : 30;
    $this->page = (int) (!isset($_GET['page'])) ? 1 : $_GET['page'];
    $this->start = ($this->page * $this->limit) - $this->limit;
    $this->next = ++$this->page;

    $this->browseNav($this->query);

    //condition on searching category
    switch ($cat) {
      case 'albums':
        $this->displayAlbums();
        break;

      case 'songs':
        $this->displaySongs("searchData");
        break;

      case 'artists':
        $this->displayArtists();
      break;

      case 'playlists':
        $this->displayPlaylists();
      break;
      
      default:
        # code...
        break;
    }
  }

  function alContainerSql() {
    $this->cat;

    $alSql = "SELECT al.album_title, al.album_id, t.artist_name FROM wt_albums as al, wt_tracks as t, wt_lang as l WHERE al.album_title LIKE '%$this->query%' AND al.album_id=t.album_id GROUP BY al.album_id ORDER BY al.album_hits DESC LIMIT $this->start, $this->limit";
    $alResult = mysqli_query( $GLOBALS['link'], $alSql );
    if( mysqli_num_rows($alResult) > 0 ) {
      while( $alRow = mysqli_fetch_assoc($alResult) ) {
        $album_title_with_year = $alRow['album_title'];
        $albumYearCheck = substr($album_title_with_year, -4);

        if(is_numeric($albumYearCheck)) {
          $al['album_title_without_year'][] = substr($album_title_with_year, 0, -5);
        } else $al['album_title_without_year'][] = $album_title_with_year;

        $al['album_title_with_year'][] = $album_title_with_year;
        $al['album_id'][] = $alRow['album_id'];
        $al['artist_name'][] = $alRow['artist_name'];
        $al['album_base_url'][] = "/album/";
      }

      $imgArray = str_replace(' ', '+', $al['album_title_with_year']);
      $imgArray2 = str_replace(' ', '+', $al['album_title_without_year']);
      $al['album_ur'] = array_map('strtolower', $imgArray);

      foreach ($imgArray as $key => $value) {
        $alLetter = substr($imgArray[$key], 0, 1);
        if(is_numeric($alLetter)) {
          $alLetter = "0-9";
        }
        $images = "http://img.wtsongs.com/images/albums/$alLetter/" . $imgArray[$key] . "/" . $imgArray[$key] . "_175x175.jpg";
        $images2 = "http://img.wtsongs.com/images/all/$alLetter/" . $imgArray[$key] . ".jpg";
        $images3 = "http://img.wtsongs.com/images/all/$alLetter/" . $imgArray2[$key] . ".jpg";
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

      $al['img_array'] = array_map('strtolower', $img);

      return array( $al );
    } else {
      //tell the pagination that data has been complete
      define('pagination_data', 'end');
    }
  }

  function songContainerSql() {
    $SongSql = "SELECT t.track_id, t.track_title, t.artist_name, t.play_hits, al.album_title, al.album_id, l.lang_title FROM wt_tracks as t, wt_albums as al, wt_lang as l WHERE track_title LIKE '%" . mysqli_escape_string($GLOBALS['link'], $this->query) . "%' AND t.album_id=al.album_id AND al.lang_id=l.lang_id ORDER BY play_hits DESC LIMIT $this->start, $this->limit";
    $songResult = mysqli_query( $GLOBALS['link'], $SongSql );
    if( mysqli_num_rows( $songResult ) > 0 ) {
      while ( $sRow = mysqli_fetch_assoc($songResult) ) {
        $s['track_id'][] = $sRow['track_id'];
        $s['track_title'][] = $sRow['track_title'];
        $s['artist_name'][] = $sRow['artist_name'];
        $s['album_title'][] = $sRow['album_title'];
        $s['album_id'][] = $sRow['album_id'];
        $s['track_playhits'][] = $sRow['play_hits'];
        $s['lang_title'][] = $sRow['lang_title'];
        if( is_numeric( substr($sRow['album_title'], -4) ) ) {
          $s['album_name_without_year'][] = substr($sRow['album_title'], 0, -5);
        } else $s['album_name_without_year'][] = $sRow['album_title'];
      }

      $s['t_title'] = str_replace(' ', '+', $s['track_title']);
      $s['track_title_url'] = array_map('strtolower', $s['t_title']);
      $s['a_title'] = str_replace(' ', '+', $s['album_title']);
      $s['album_title_url'] = array_map('strtolower', $s['a_title']);

      $s['artist_img'] = "http://img.wtsongs.com/images/static/song_default_175x175";

      unset( $s['t_title'], $s['a_title'], $s['ar_img'] );
      return array( $s );
    }
    //tell the pagination that data has been complete
    else define('pagination_data', 'end');
  }

  function arContainerSql() {
    $arSql = "SELECT artist_id, artist_name, seokey FROM `wt_artists` WHERE artist_name LIKE '%$this->query%' LIMIT " . $this->start . ", "  . $this->limit;
    $arResult = mysqli_query( $GLOBALS['link'], $arSql );
    if( mysqli_num_rows($arResult) > 0 ) {
      while( $arRow = mysqli_fetch_assoc($arResult) ) {
        $ar['artist_name'][] = $arRow['artist_name'];
        $ar['seokey'][] = $arRow['seokey'];
        $ar['artist_id'][] = $arRow['artist_id'];
      }

      $ar['artist_url_case'] = str_replace(' ', '+', $ar['artist_name']);
      $ar['artist_url'] = array_map('strtolower', $ar['artist_url_case']);

      foreach ($ar['artist_url'] as $key => $value) {
        $arLetter = substr($ar['artist_url'][$key], 0, 1);
        if(is_numeric($arLetter)) {
          $arLetter = "0-9";
        }
        $images = "http://img.wtsongs.com/images/artists/$arLetter/" . $ar['artist_url'][$key] . ".jpg";
        $images2 = "http://img.wtsongs.com/images/artists/$arLetter/" . $ar['artist_url'][$key] . "_175x175.jpg";
        if(@getimagesize($images)) {
          $img[] = $images;
        } elseif(@getimagesize($images2)) {
          $img[] = $images2;
        } else {
          $img[] = "http://img.wtsongs.com/images/static/song_default_175x175.jpg";
        }
      }

      $ar['img_array'] = array_map('strtolower', $img);

      return array( $ar );
    }
    //tell the pagination that data has been complete
    else define('pagination_data', 'end');
  }

  //used for playlist searching
  function usersPlContainerSql() {
    $userPlSql = "SELECT pl.playlist_title, pl.playlist_id, pl.user_id, u.firstname, u.unique_user_name, pd.track_id, al.album_title FROM wt_playlists as pl, wt_users as u, wt_playlist_data as pd, wt_tracks as t, wt_albums as al WHERE pl.playlist_title LIKE '%$this->query%' AND pl.released=1 AND pl.user_id=u.id AND pl.playlist_id=pd.playlist_id AND t.track_id=pd.track_id AND t.album_id=al.album_id GROUP BY pl.playlist_id HAVING(`track_id`)>3 LIMIT " . $this->start . ", "  . $this->limit;
    $userPlResult = mysqli_query( $GLOBALS['link'], $userPlSql );
    if( mysqli_num_rows($userPlResult) > 0 ) {
      while( $plRow = mysqli_fetch_assoc($userPlResult) ) {
        $ac['album_title_without_year'][] = $plRow['playlist_title'];

        $ac['album_title_with_year'][] = $plRow['playlist_title'];
        $ac['album_id'][] = $plRow['playlist_id'];
        $ac['artist_name'][] = $plRow['firstname'];
        if( $plRow['unique_user_name'] == "wtsongs2015" )
          $ac['album_base_url'][] = "/playlists/";
        else $ac['album_base_url'][] = "/playlists/" . $plRow['unique_user_name'] . "/";
        $ac['album_img'][] = $plRow['album_title'];
      }

      $imgArray = str_replace(' ', '+', $ac['album_img']);
      $imgAlbum = str_replace(' ', '%20', $ac['album_img']);
      $ac['playlist_url'] = str_replace(' ', '+', $ac['album_title_without_year']);
      $ac['album_ur'] = array_map('strtolower', $ac['playlist_url']);

      foreach ($imgArray as $key => $value) {
        $plLetter = substr($imgArray[$key], 0, 1);
        if(is_numeric($plLetter)) {
          $plLetter = "0-9";
        }
        $images = "http://img.wtsongs.com/images/albums/$plLetter/" . $imgAlbum[$key] . "/" . $imgArray[$key] . "_175x175.jpg";
        $images2 = "http://img.wtsongs.com/images/all/$plLetter/" . $imgArray[$key] . ".jpg";
        if(@getimagesize($images)) {
          $img[] = strtolower( $images );
        } elseif(@getimagesize($images2)) {
          $img[] = strtolower( $images2 );
        } else {
          $img[] = "http://img.wtsongs.com/images/static/song_default_175x175.jpg";
        }
      }

      $ac['img_array'] = array_map('strtolower', $img);

      return array( $ac );
    } else {
      //tell the pagination that data has been complete
      define('pagination_data', 'end');
    }
  }

  function browseNav($qtext) {
?>
<div class="browse_page_nav1"><h1 class="headText">Search Results / <?php echo $qtext; ?></h1></div>
<div class="browse_page_nav1">
  <ul>
    <li><a href="/search/songs/<?php echo $qtext; ?>" title="Songs" id="songs" data-pjax="#main" data-push="true" data-target="#main">Songs</a></li>
    <li><a href="/search/albums/<?php echo $qtext; ?>" title="Albums" id="albums" data-pjax="#main" data-push="true" data-target="#main">Albums</a></li>
    <li><a href="/search/artists/<?php echo $qtext; ?>" title="Artists" id="artists" data-pjax="#main" data-push="true" data-target="#main">Artists</a></li>
    <li><a href="/search/playlists/<?php echo $qtext; ?>" title="Playlist" id="playlists" data-pjax="#main" data-push="true" data-target="#main">Playlists</a></li>
  </ul>
</div>

<?php

  }

  //function for displaying searched albums
  function displayAlbums() {
    list( $alData ) = $this->alContainerSql();
    if( isset($alData) ) include root_dir . '/include/main-content/content_fun/search_albums.php';
    else echo '<p class="seogiUI" style="padding: 35px 0px; font-size: 20px; color: rgb(153, 153, 153); float: left; text-align: center; width: 100%;">Sorry! No album is available for this keyword.</p>';
  }

  function displaySongs($data) {
    list( $trackData ) = $this->songContainerSql();
    if( isset($trackData) ) include root_dir . '/include/main-content/content_fun/search_songs.php';
    else echo '<p class="seogiUI" style="padding: 35px 0px; font-size: 20px; color: rgb(153, 153, 153); float: left; text-align: center; width: 100%;">Sorry! No song is available for this keyword.</p>';
  }

  function displayArtists() {
    //define for pagination conditioning
    $searchedAr = true;
    include root_dir . '/include/main-content/content_fun/browse_index_artists.php';
  }

  function displayPlaylists() {
    //define usersplaylist for call search playlist data
    define('usersplaylist', true);
    //define for pagination conditioning
    $searcPl = true;
    //show searched playlists data
    include root_dir . '/include/main-content/content_fun/browse_index.php';
  }

}

?>