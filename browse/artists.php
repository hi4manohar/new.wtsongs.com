<?php
$limit = 30;
$page = (int) (!isset($_GET['page'])) ? 1 : $_GET['page'];
$pageSql = "SELECT * FROM wt_albums where lang_id='2' ORDER BY album_id DESC";
# find out query stat point
$start = ($page * $limit) - $limit;
# query for page navigation
$result = mysqli_query( $link, $pageSql );
if( mysqli_num_rows( $result ) > ($page * $limit) ){
  $next = ++$page;
}

class albumList {

  public $totalData;
  public $startLimit;
  public $endLimit;
  public $next;
  public $albumsLang;
  public $pUrl;

  public function alContainer($lang) {
    $this->pUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $this->albumsLang = $lang;
    $this->startLimit = $GLOBALS['start'];
    $this->endLimit = $GLOBALS['limit'];
    $this->next = $GLOBALS['next'];
    $this->alContent();
  }

  function alContainerSql() {
    $acSql = "SELECT al.album_title, al.album_id, t.artist_name FROM wt_albums as al, wt_tracks as t, wt_lang as l WHERE al.album_id=t.album_id AND l.lang_title='$this->albumsLang' AND l.lang_id=al.lang_id GROUP BY al.album_id ORDER BY al.album_hits DESC LIMIT " . $this->startLimit . ", "  . $this->endLimit;
    $acResult = mysqli_query( $GLOBALS['link'], $acSql );
    if( mysqli_num_rows($acResult) ) {
      while( $acRow = mysqli_fetch_assoc($acResult) ) {
        $album_title_with_year = $acRow['album_title'];
        $albumYearCheck = substr($album_title_with_year, -4);

        if(is_numeric($albumYearCheck)) {
          $ac['album_title_without_year'][] = substr($album_title_with_year, 0, -5);
        } else $ac['album_title_without_year'][] = $album_title_with_year;

        $ac['album_title_with_year'][] = $album_title_with_year;
        $ac['album_id'][] = $acRow['album_id'];
        $ac['artist_name'][] = $acRow['artist_name'];
      }

      $imgArray = str_replace(' ', '+', $ac['album_title_with_year']);
      $imgArray2 = str_replace(' ', '+', $ac['album_title_without_year']);
      $ac['album_ur'] = array_map('strtolower', $imgArray);

      foreach ($imgArray as $key => $value) {
        $acLetter = substr($imgArray[$key], 0, 1);
        if(is_numeric($acLetter)) {
          $acLetter = "0-9";
        }
        $images = "http://img.wtsongs.com/images/albums/$acLetter/" . $imgArray[$key] . "/" . $imgArray[$key] . "_175x175.jpg";
        $images2 = "http://img.wtsongs.com/images/all/$acLetter/" . $imgArray[$key] . ".jpg";
        $images3 = "http://img.wtsongs.com/images/all/$acLetter/" . $imgArray2[$key] . ".jpg";
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

      $ac['img_array'] = array_map('strtolower', $img);

      return array( $ac );
    } else {
      header('/');
      echo 'Page not found!';
      exit();
    }
  }

  function SelectorBar() {

?>

<div class="browse_page_corousal_top">
  <form name="select" class="select" method="post">
    <select name="list" form="album_form">
        <option value="Popularity">Popularity</option>
        <option value="A-Z">A-Z</option>
        <option value="Release date">Release date</option>
    </select>
  </form>
</div>

<?php

  }

  function browseNav() {

?>

<div class="browse_page_nav1">
  <ul>
    <li><a href="#" title="Albums">Albums</a></li>
    <li><a href="#" title="Genre">Genre</a></li>
    <li><a href="#" title="Artist">Artist</a></li>
    <li><a href="#" title="Popular">Popular</a></li>
    <li><a href="#" title="Cast">Cast</a></li>
  </ul>
</div>

<?php

  }

  function alContent() {

?>

<div class="browse_page_container">
<?php $this->SelectorBar(); ?>
<div class="browse_page_corousal">
  <?php list( $acData ) = $this->alContainerSql(); ?>
  <?php foreach( $acData['album_id'] as $key => $value ) { ?>
  <div class="hindi_albums">
    <a href="/album/<?php echo $acData['album_ur'][$key]; ?>">
    <div class="hindi_albums_player play_album"></div>
    <div class="like_us"></div>
    <div class="hindi_albums_img">
      <img src="<?php echo $acData['img_array'][$key]; ?>" alt="<?php echo $acData['album_title_with_year'][$key] ?>" />
    </div>
    </a>
    <div class="hindi_albums_movies_details">
      <div class="hindi_albums_movie_name">
        <a href="/album/<?php echo $acData['album_ur'][$key]; ?>" title="<?php echo $acData['album_title_with_year'][$key] ?>"><?php echo $acData['album_title_without_year'][$key]; ?></a>
        <div class="hindi_albums_artist">
          <?php
          $art_parts = explode(",", $acData['artist_name'][$key]);
          foreach ($art_parts as $artkey => $artvalue) {
            echo '<a href="javascript:void(0)" class="singer" title="" data-pjax="#main">' . $art_parts[$artkey] . '</a>,';
          }
          ?>
        </div>
      </div>                  
    </div>
  </div>
  <?php } ?>
  <div class="pagination_container">
    <center>
      <div class="pagination_container_inner"></div>
    </center>
  </div>
  <!--page navigation-->
  <?php if (isset($this->next)): ?>
  <div class="innav">
    <a href='<?php echo $this->pUrl; ?>&page=<?php echo $this->next?>'>Next</a>
  </div>
  <?php endif?>
</div>
</div>

<?php

  }

}

?>