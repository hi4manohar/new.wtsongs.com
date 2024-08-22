<?php
if($cat == "songs" || $cat == "overview") {
  $limit = 12;
  $page = (int) (!isset($_GET['page'])) ? 1 : $_GET['page'];
  $pageSql = "SELECT * FROM wt_tracks WHERE artist_name LIKE '%" . mysqli_escape_string($link, artist) . "%'";
  # find out query stat point
  $start = ($page * $limit) - $limit;
  # query for page navigation
  $result = mysqli_query( $link, $pageSql );
  $next = ++$page;
} elseif( $cat == "albums" ) {
  $limit = 12;
  $page = (int) (!isset($_GET['page'])) ? 1 : $_GET['page'];
  $pageSql = "SELECT DISTINCT t.album_id FROM wt_tracks AS t, wt_albums AS al WHERE t.artist_name LIKE '%" . mysqli_escape_string( $GLOBALS['link'], artist ) . "%' AND t.album_id=al.album_id GROUP BY al.album_title";
  $start = ($page * $limit) - $limit;
  $result = mysqli_query( $link, $pageSql );
  $next = ++$page;
}

class artistsContent {

  public $trackData;
  public $artistName;
  public $artistUrl;
  public $next;
  public $cat;
  public $start;
  public $limit;

  public function arPage($trackData) {
    $this->next=$GLOBALS['next'];
    $this->cat = $GLOBALS['cat'];
    $this->start = $GLOBALS['start'];
    $this->limit = $GLOBALS['limit'];
    $this->artistName = ucwords(artist);
    $this->artistUrl = str_replace(' ', '+', artist);
    $this->trackData = $trackData;
    $this->arHeader();
    if($this->cat == "songs" || $this->cat == "overview") {
      if( $this->cat == "overview" ) $this->arExistance();
      $this->arContent($trackData);
    } else {
      $this->arOverviewAlbum();
    } 
  }

  function arOverviewedAlbum() {
    $aroaSql = "SELECT DISTINCT t.album_id, t.artist_name, al.album_title FROM wt_tracks AS t, wt_albums AS al WHERE t.artist_name LIKE '%" . mysqli_escape_string( $GLOBALS['link'], artist ) . "%' AND t.album_id=al.album_id GROUP BY al.album_title LIMIT $this->start, $this->limit";
    $aroaResult = mysqli_query( $GLOBALS['link'], $aroaSql );
    if (!$aroaResult) {
      die('Invalid query: ' . mysql_error());
    } else{
      if( mysqli_num_rows($aroaResult) > 0 ) {
        while ( $aroaRow = mysqli_fetch_assoc($aroaResult) ) {
          $aroa['album_id'][] = $aroaRow['album_id'];
          $albumYearCheck = substr($aroaRow['album_title'], -4);

          if( is_numeric($albumYearCheck) ) {
            $aroa['album_title_without_year'][] = substr( $aroaRow['album_title'], 0, -5 );
          } else $aroa['album_title_without_year'][] = $aroaRow['album_title'];

          $aroa['album_title_with_year'][] = $aroaRow['album_title'];
          $aroa['album_artist'][] = $aroaRow['artist_name'];
        }

        $ttDataSql = mysqli_query( $GLOBALS['link'], "SELECT DISTINCT t.album_id FROM wt_tracks AS t, wt_albums AS al WHERE t.artist_name LIKE '%" . mysqli_escape_string( $GLOBALS['link'], artist ) . "%' AND t.album_id=al.album_id GROUP BY al.album_title" );
        $aroa['totalData'] = mysqli_num_rows( $ttDataSql );

        $imgArray = str_replace(' ', '+', $aroa['album_title_with_year']);
        $imgArray2 = str_replace(' ', '+', $aroa['album_title_without_year']);
        $aroa['album_url'] = array_map('strtolower', $imgArray);

        $this->set_generic();

        foreach ($imgArray as $key => $value) {

          //fetching the images using generic class
          $aroa['img_array'][] = $this->generic->get_images( "album", $aroa['album_title_with_year'][$key], "_175x175" );
        }

        unset( $imgArray, $imgArray2, $img );

        return array( $aroa );
      }
      else {
        define('pagination_data', 'end');
        header('Location: http://www.wtsongs.com/');
      }
    }
  }

  //make generic class public for common actions
  function set_generic() {
    global $generic;
    $this->generic = $generic;
  }

  function arExistance() {
    global $common_class, $common;
    $art_exist = $common_class->execute_query("SELECT artist_id FROM wt_artists WHERE artist_name='" . artist . "'");
    if( mysqli_num_rows( $art_exist ) == 1 ) {
      $artist_id = mysqli_fetch_array( $art_exist, MYSQLI_ASSOC );
      $artist_id = $artist_id['artist_id'];
      $common->update_a_or_pl_hits($artist_id, "artist");
      //update hits
    } else {
      //insert artist
      //update hits
    }
  }

  function arHeader() {
    if( !@getimagesize($this->trackData['artist_img']) ) {
      $this->trackData['artist_img'] = "http://img.wtsongs.com/images/static/song_default_175x175.jpg";
    }

?>

<div class="album_header_containner">
  <div class="album_containner_inner">
    <div class="album_containner_inner_img">
      <img src="<?php echo $this->trackData['artist_img']; ?>" alt="<?php echo artist; ?>">
    </div>
    <a href="javascript:void(0);">
      <div class="album_player albumPlayerIcon"></div>
    </a>
    <div class="album_containner_details">
      <div class="album_details">
        <p class="album_name dotes"><?php echo $this->artistName; ?></p>
        <p class="album_length"></p>
        <p class="year album_length"></p>
        <p class="album_favorites"> <!-- 3,063 Favorites --></p>
        <p class="album_singer dotes"></p>
        <div class="button">
          <div class="download_button downloadIcon">
            <a href="javascript:void(0)"></a>
          </div>
          <div class="comment_button commentIcon">
            <a href="javascript:void(0)"></a>
          </div>
          <!--
          <div class="favorite favouriteIcon">
            <a href="favorite" title="add to favorite"></a>
          </div>
          <div class="add addIcon">
            <a href="javascript:void(0)" title="add to playlist"></a>
          </div>
          -->
          <div class="share shareIcon headershare">
            <a class="shareheaderartist" href="javascript:void(0)" title="share" data-type="share" data-value="artist<?php echo $this->artistName; ?>"></a>
          </div>
        </div>
      </div>
    </div>
    <!-- like butoon  end -->
    <div class="album_details_right">
      <div class="fb-like" data-href="https://facebook.com/wtsongs2015" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
    </div>
    <!-- like butoon  html end -->
  </div>
</div>

<?php

  }

  function album_identity() {

?>

    <div class="album_identity">
      <ul class="album_identity_inner">
        <li><a href="/artist/<?php echo $this->artistUrl; ?>" class="nav3 overview" title="overview" data-pjax="#main" data-push="true" data-target="#main">OVERVIEW</a></li>
        <li><a href="/artist/<?php echo $this->artistUrl; ?>/albums" class="nav3 albums" title="albums" data-pjax="#main" data-push="true" data-target="#main">ALBUMS</a></li>
        <li><a href="/artist/<?php echo $this->artistUrl; ?>/songs" class="nav3 songs" title="songs" data-pjax="#main" data-push="true" data-target="#main">SONGS</a></li>
      </ul>
    </div>

<?php

  }

  function arContent() {
    include root_dir . '/include/main-content/content_fun/artist_details.php';
  }

  function arOverviewAlbum() {
    if( $this->cat == "albums" )
      $this->album_identity();

?>

<div class="total_albums">
  <?php list( $aroaData ) = $this->arOverviewedAlbum(); ?>
  <a href="/artist/<?php echo $this->artistUrl; ?>/albums" data-pjax="#main" data-push="true" data-target="#main"> <?php echo $this->artistName; ?> Albums (<?php echo $aroaData['totalData']; ?>)</a>
</div>
<div class="browse_page_corousal">
  <?php foreach( $aroaData['album_id'] as $key => $value ) { ?>
  <div class="hindi_albums">
    <a href="/album/<?php echo $aroaData['album_url'][$key]; ?>" data-push="true" data-target="#main">
    <div class="hindi_albums_player play_album"></div>
    <div class="like_us"></div>
    <div class="hindi_albums_img">
      <img src="<?php echo $aroaData['img_array'][$key]; ?>" alt="<?php echo $aroaData['album_title_with_year'][$key] ?>"/>
    </div>
    </a>
    <div class="hindi_albums_movies_details">
      <div class="hindi_albums_movie_name">
        <a href="/album/<?php echo $aroaData['album_url'][$key]; ?>" title="<?php echo $aroaData['album_title_with_year'][$key] ?>" data-push="true" data-target="#main"><?php echo $aroaData['album_title_without_year'][$key]; ?></a>
        <div class="hindi_albums_artist">
          <?php
          $art_parts = explode(",", $aroaData['album_artist'][$key]);
          foreach ($art_parts as $arkey => $arvalue) {
            $art = strtolower(str_replace(' ', '+', $art_parts[$arkey]));
            if( substr($art, 0, 1) == "+" ) $art = substr($art, 1);
            echo '<a class="singer" href="/artist/' . $art . '/" title="' . $art_parts[$arkey] . '" data-pjax="#main" data-push="true" data-target="#main">' . $art_parts[$arkey] . ', </a>';
          }
          ?>
        </div>
      </div>                  
    </div>
  </div>
  <?php }
  if( $this->cat == "albums" ):
  if(defined('pagination_data')) { unset($this->next); }
  if (isset($this->next)) pagination(page_url . "&page=" . $this->next);
  ?>
  <?php endif; ?>
</div>

<?php

  }

}


?>