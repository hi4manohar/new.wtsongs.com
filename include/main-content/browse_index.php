<?php
$limit = 30;
$page = (int) (!isset($_GET['page'])) ? 1 : $_GET['page'];
# find out query stat point
$start = ($page * $limit) - $limit;
# query for page navigation
$next = ++$page;

class albumList {

  public $totalData;
  public $startLimit;
  public $endLimit;
  public $next;
  public $albumsLang;
  public $pUrl;

  public function alContainer($lang, $category) {
    $this->pUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $this->browseCat = $category;
    $this->albumsLang = $lang;
    $this->startLimit = $GLOBALS['start'];
    $this->endLimit = $GLOBALS['limit'];
    $this->next = $GLOBALS['next'];
    switch ($category) {
      case 'albums':
        $this->alContent();
        break;

      case 'artists':
        $this->arContent();
        break;

      //case 'casts':
        //$this->csContent();
        //break;

      case 'genres':
        $this->gnContent();
        break;
      
      default:
        goto_errorpage();
        break;
    }
  }

  function alContainerSql() {
    $sortbyArray = array( 'popularity' => 'al.album_hits DESC', 'a-z' => 'al.album_title ASC', 'new_released' => 'al.release_date DESC' );
    if( isset($_GET['sortby']) && array_key_exists($_GET['sortby'], $sortbyArray) ) {

      $sortby = $sortbyArray[$_GET['sortby']];

    } else $sortby = "al.album_hits DESC";
    $acSql = "SELECT al.album_title, al.album_id, t.artist_name FROM wt_albums as al, wt_tracks as t, wt_lang as l WHERE al.album_id=t.album_id AND l.lang_title='$this->albumsLang' AND l.lang_id=al.lang_id GROUP BY al.album_id ORDER BY $sortby LIMIT " . $this->startLimit . ", "  . $this->endLimit;
    $acResult = mysqli_query( $GLOBALS['link'], $acSql );
    if( mysqli_num_rows($acResult) > 0 ) {
      while( $acRow = mysqli_fetch_assoc($acResult) ) {
        $album_title_with_year = $acRow['album_title'];
        $albumYearCheck = substr($album_title_with_year, -4);

        if(is_numeric($albumYearCheck)) {
          $ac['album_title_without_year'][] = substr($album_title_with_year, 0, -5);
        } else $ac['album_title_without_year'][] = $album_title_with_year;

        $ac['album_title_with_year'][] = $album_title_with_year;
        $ac['album_id'][] = $acRow['album_id'];
        $ac['artist_name'][] = $acRow['artist_name'];
        $ac['album_base_url'][] = "/album/";
      }

      $imgArray = str_replace(' ', '+', $ac['album_title_with_year']);
      $ac['album_ur'] = array_map('strtolower', $imgArray);

      $this->generic = $this->set_generic();

      foreach ($ac['album_title_with_year'] as $key => $value) {
        $img[] = $this->generic->get_images( "album", $value, "_175x175" );
      }

      $ac['img_array'] = array_map('strtolower', $img);

      return array( $ac );
    } else {
      redirect("/");
      echo 'Page not found!';
      exit();
    }
  }

  function usersPlContainerSql() {
    $userPlSql = "SELECT pl.playlist_title, pl.playlist_id, pl.user_id, u.firstname, u.unique_user_name, pd.track_id, al.album_title FROM wt_playlists as pl, wt_users as u, wt_playlist_data as pd, wt_tracks as t, wt_albums as al WHERE user_id<>0 AND pl.released=1 AND pl.user_id=u.id AND pl.playlist_id=pd.playlist_id AND t.track_id=pd.track_id AND t.album_id=al.album_id GROUP BY pl.playlist_id HAVING(`track_id`)>3 LIMIT " . $this->startLimit . ", "  . $this->endLimit;
    $userPlResult = mysqli_query( $GLOBALS['link'], $userPlSql );
    if( mysqli_num_rows($userPlResult) > 0 ) {
      while( $plRow = mysqli_fetch_assoc($userPlResult) ) {
        $ac['album_title_without_year'][] = $plRow['playlist_title'];

        $ac['album_title_with_year'][] = $plRow['playlist_title'];
        $ac['album_id'][] = $plRow['playlist_id'];
        $ac['artist_name'][] = $plRow['firstname'];
        $ac['artist_name_url'][] = $plRow['unique_user_name'];
        if( $plRow['unique_user_name'] == "wtsongs2015" )
          $ac['album_base_url'][] = "/playlists/";
        else $ac['album_base_url'][] = "/playlists/" . $plRow['unique_user_name'] . "/";
        $ac['album_img'][] = $plRow['album_title'];
      }

      $ac['playlist_url'] = str_replace(' ', '+', $ac['album_title_without_year']);
      $ac['album_ur'] = array_map('strtolower', $ac['playlist_url']);

      $this->generic = $this->set_generic();

      foreach ($ac['album_img'] as $key => $value) {
        $img[] = $this->generic->get_images( "album", $ac['album_img'][$key], "_175x175" );
      }

      $ac['artist_base_url'] = "/user/";

      $ac['img_array'] = array_map('strtolower', $img);

      return array( $ac );
    } else {
      
    }
  }

  function arContainerSql() {
    $arSql = "SELECT artist_id, artist_name, seokey FROM `wt_artists` WHERE main_role_id=1 ORDER BY artist_id ASC LIMIT " . $this->startLimit . ", "  . $this->endLimit;
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
    } else {
      redirect("/");
      echo 'Page not found!';
      exit();
    }
  }

  function gnContainerSql() {
    $acSql = "SELECT al.album_title, al.album_id, t.artist_name FROM wt_albums as al, wt_tracks as t, wt_lang as l, wt_genre as g WHERE g.genre_title='$this->albumsLang' AND al.genre_id=g.genre_id AND al.album_id=t.album_id AND l.lang_id=al.lang_id GROUP BY al.album_id ORDER BY al.album_hits DESC LIMIT " . $this->startLimit . ", "  . $this->endLimit;
    $acResult = mysqli_query( $GLOBALS['link'], $acSql );
    if( mysqli_num_rows($acResult) > 0 ) {
      while( $acRow = mysqli_fetch_assoc($acResult) ) {
        $album_title_with_year = $acRow['album_title'];
        $albumYearCheck = substr($album_title_with_year, -4);

        if(is_numeric($albumYearCheck)) {
          $ac['album_title_without_year'][] = substr($album_title_with_year, 0, -5);
        } else $ac['album_title_without_year'][] = $album_title_with_year;

        $ac['album_title_with_year'][] = $album_title_with_year;
        $ac['album_id'][] = $acRow['album_id'];
        $ac['artist_name'][] = $acRow['artist_name'];
        $ac['album_base_url'][] = "/album/";
      }

      $imgArray = str_replace(' ', '+', $ac['album_title_with_year']);
      $ac['album_ur'] = array_map('strtolower', $imgArray);

      $this->generic = $this->set_generic();

      foreach ($ac['album_title_with_year'] as $key => $value) {
        $img[] = $this->generic->get_images( "album", $value, "_175x175" );
      }

      $ac['img_array'] = array_map('strtolower', $img);

      return array( $ac );
    } else {
      define('pagination_data', 'end');
      redirect("/");
      echo 'Page not found!';
      exit();
    }
  }

  function set_generic() {
    global $generic;
    return $generic;
  }

  function SelectorBar($link) {

?>

<div class="browse_page_corousal_top">
<div class="menu">
  <ul>
    <li>
      <a href="javascript:void(0)">Popularity<img src="/assets/img/caret.png"></a>
      <ul>
        <li><a href="<?php echo $link; ?>&amp;sortby=popularity" data-pjax="#main" data-push="true" data-target="#main">popularity</a></li>
        <li><a href="<?php echo $link; ?>&amp;sortby=a-z" data-push="true" data-target="#main">A-Z</a></li>
        <li><a href="<?php echo $link; ?>&amp;sortby=new_released" data-push="true" data-target="#main">New Released</a></li>
      </ul>
    </li>
  </ul>
</div>
</div>

<?php

  }

  function browseNav() {

?>

<div class="browse_page_nav1">
  <ul>
    <li><a href="/access/albums/hindi" title="Albums" id="albums" data-pjax="#main" data-push="true" data-target="#main">Albums</a></li>
    <li><a href="/access/genres/bollywood" title="Genre" id="genres" data-pjax="#main" data-push="true" data-target="#main">Genre</a></li>
    <li><a href="/access/artists/hindi" title="Artist" id="artists" data-pjax="#main" data-push="true" data-target="#main">Artist</a></li>
    <li><a href="/newreleased/hindi" title="Popular" id="newreleased" data-pjax="#main" data-push="true" data-target="#main">New Releases</a></li>
    <li><a href="/popularcategory/stars" title="Cast" id="cast" data-pjax="#main" data-push="true" data-target="#main">Cast</a></li>
  </ul>
</div>

<?php

  }

  //also included userplaylist part
  function alContent() {
    //false becuase when this file will be included in search album.php then it will be true
    $searcPl = false;
    require root_dir . "/include/main-content/content_fun/browse_index.php";
  }

  function arContent() {
    //false becuase when this file will be included in search artist.php then it will be true
    $searchedAr = false;
    require root_dir . "/include/main-content/content_fun/browse_index_artists.php";
  }

  function gnContent() {
    $genre_data = true;
    require root_dir . "/include/main-content/content_fun/browse_index.php";
  }

}

?>