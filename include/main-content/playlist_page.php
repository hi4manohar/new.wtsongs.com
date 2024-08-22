<?php
$limit = 24;
$page = (int) (!isset($_GET['page'])) ? 1 : $_GET['page'];
$pageSql = "SELECT * FROM wt_playlists WHERE user_id='0' AND released='1' AND lang_id='2'";
# find out query stat point
$start = ($page * $limit) - $limit;
# query for page navigation
$result = mysqli_query( $link, $pageSql );
  $next = ++$page;

class fpContent {

  public $totalData;
  public $startLimit;
  public $endLimit;
  public $next;
  public $plLang;
  public $pUrl;

  public function fpBox($lang) {
    $this->pUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $this->plLang = $lang;
    $this->startLimit = $GLOBALS['start'];
    $this->endLimit = $GLOBALS['limit'];
    $this->next = $GLOBALS['next'];
    $this->fpBar();
  }

  //featured playlist query
  function fPlaylistSql() {

    $fp_sql = "SELECT playlist_id, playlist_title, track_id, term_id, track_title, artist_name, album_id, album_title, lang_title, total, tf
FROM (
SELECT p.playlist_id, 
    s.track_id, 
    p.term_id, 
    s.track_title, 
    s.artist_name, 
    p.playlist_title, 
    s.album_id, 
    al.album_title, 
    lg.lang_title,
    (select count(um.meta_id) from wt_usermeta um where um.object_id = p.playlist_id) tf,
    (select count(sr1.track_id) from wt_playlist_data sr1 
     where sr1.playlist_id=p.playlist_id 
     group by sr1.playlist_id) as total,
       @r := IF (@pid = p.playlist_id,
                 IF (@pid := p.playlist_id, @r+1, @r+1),
                 IF (@pid := p.playlist_id, 1, 1)) AS rn
FROM wt_playlists AS p
CROSS JOIN (SELECT @r:=0, @pid:=0) AS vars
INNER JOIN wt_playlist_data AS sr ON p.playlist_id = sr.playlist_id 
    AND p.user_id=0 
    AND p.term_id=9 
    AND p.lang_id=2 
    AND p.released=1
INNER JOIN wt_tracks AS s ON sr.track_id = s.track_id
INNER JOIN wt_albums AS al ON s.album_id = al.album_id
INNER JOIN wt_lang AS lg ON al.lang_id = lg.lang_id
ORDER BY p.playlist_id DESC, s.track_id ) AS t
WHERE t.rn <= 2 LIMIT " . $this->startLimit . ", "  . $this->endLimit;
    $fp_result = mysqli_query( $GLOBALS['link'], $fp_sql );
    //output data of freature playlist
    if( mysqli_num_rows($fp_result) > 0 ) {

      while( $fp_row = mysqli_fetch_assoc($fp_result) ) {
        $fp['playlist_title'][] = $fp_row['playlist_title'];
        $fp['track_title'][] = $fp_row['track_title'];
        $fp['track_artist'][] = $fp_row['artist_name'];
        $fp['track_id'][] = $fp_row['track_id'];
        $fp['album_id'][] = $fp_row['album_id'];
        $fp['album_title'][] = $fp_row['album_title'];
        $fp['album_lang'][] = $fp_row['lang_title'];
        //total_track
        $fp['total_track'][] = $fp_row['total'];
        $fp['tf'][] = $fp_row['tf'];
      }      
    } else {
      define('pagination_data', 'end');
    }

    //image Data
    //uniqueness of data
    foreach ($fp['total_track'] as $tkey => $tvalue) {
      if($tkey % 2 == 0) {
        $fp['t_track_index'][] = $fp['total_track'][$tkey];
        $fp['album_lang_index'][] = $fp['album_lang'][$tkey];
        $fp['pl_title_index'][] = $fp['playlist_title'][$tkey];
        $fp['tf_index'][] = $fp['tf'][$tkey];
      }
    }
    unset( $fp['total_track'], $fp['album_lang'], $fp['playlist_title'], $fp['tf'] );
    $fp['img_name'] = str_replace(" ", "+", $fp['pl_title_index']);
    $fp['img_name_array'] = array_map('strtolower', $fp['img_name']);
    unset($fp['img_name']);

    foreach ($fp['pl_title_index'] as $key => $value) {

      $this->generic = $this->set_generic();
      $fp['image_src'][] = $this->generic->get_images( "playlist", $value, "_80x80" );
    }

    $fp['full_img_src'] = array_map('strtolower', $fp['image_src']);
    unset($fp['image_src']);

    $fp['album_img'] = str_replace(' ', '+', $fp['album_title']);
    $fp['album_img_name'] = array_map('strtolower', $fp['album_img']);
    unset($fp['album_img']);

    return array( $fp );
  }

  function set_generic() {
    global $generic;
    return $generic;
  }

  function fpBar() {

?>

<div class="playlist_page">
  <div class="playlist_content_wrapper">
  <?php 
  list( $fpData ) = $this->fPlaylistSql();
  ?>
  <?php foreach ($fpData['pl_title_index'] as $key => $value) { ?>
    <div class="playlist_main">
      <div class="playlist_main_inner">
        <div class="bollywood_top_50">
        <a href="/playlists/<?php echo $fpData['img_name_array'][$key]; ?>" data-pjax="#main" data-push="true" data-target="#main">
          <div class="bollywood_top_50_img">
            <img src="<?php echo $fpData['full_img_src'][$key]; ?>" alt="<?php echo $fpData['pl_title_index'][$key]; ?>">
          </div>
          <div class="bollywood_top_50_player_img play_album"></div>
        </a>
          <div class="bollywood_top_50_heading">
            <a href="/playlists/<?php echo $fpData['img_name_array'][$key]; ?>" title="<?php echo $fpData['pl_title_index'][$key]; ?>" data-pjax="#main" data-push="true" data-target="#main"><?php echo $fpData['pl_title_index'][$key]; ?></a>
          </div>
          <div class="bollywood_top_50_favorite">
            <p><?php echo $fpData['t_track_index'][$key]; ?> Songs <br><?php echo $fpData['tf_index'][$key]; ?> Favorites</p>
          </div>
        </div>
        <hr/>
        <div class="album_track first_song">

        <?php
          $jsonData = array(
            'id' => $fpData['track_id'][$key*2],
            'trackTitle' => $fpData['track_title'][$key*2],
            'fp_title' => $fpData['pl_title_index'][$key],
            'albumId' => $fpData['album_id'][$key*2],
            'albumTitle' => $fpData['album_title'][$key*2],
            'artist' => $fpData['track_artist'][$key*2],
            'album_lang' => $fpData['album_lang_index'][$key],
            'audio_cover' => "http://img.wtsongs.com/images/albums/" . $fpData['album_title'][$key*2] . "/" . $fpData['album_img_name'][$key*2] . "_80x80.jpg"
            );
        ?>

          <!-- json data -->
            <span class="jsontrack row<?php echo $fpData['track_id'][$key*2]; ?>" style="display:none;"><?php echo json_encode($jsonData); ?></span>


          <div class="song_player play_album track_player" dataClass="<?php echo $fpData['track_id'][$key*2]; ?>"></div>
          <div class="song_name">
              <a href="#"><?php echo $fpData['track_title'][$key*2]; ?></a>
          </div>
          <div class="song_movie_name dotes">
          <?php
          $art_parts = explode(",", $fpData['track_artist'][($key*2)]);
          foreach ($art_parts as $artkey => $artvalue) {
            $art = strtolower(str_replace(' ', '+', $art_parts[$artkey]));
            if( substr($art, 0, 1) == "+" )
              $art = substr($art, 1);
            echo '<a href="/artist/' . $art . '/" title="' . $art_parts[$artkey] . '" data-pjax="#main" data-push="true" data-target="#main">' . $art_parts[$artkey] . ', </a>';
          }
          ?>
          </div>
        </div>
        <hr/>
        <div class="album_track second_song">

        <?php
          $jsonData = array(
            'id' => $fpData['track_id'][($key*2)+1],
            'trackTitle' => $fpData['track_title'][($key*2)+1],
            'fp_title' => $fpData['pl_title_index'][$key],
            'albumId' => $fpData['album_id'][($key*2)+1],
            'albumTitle' => $fpData['album_title'][($key*2)+1],
            'artist' => $fpData['track_artist'][($key*2)+1],
            'album_lang' => $fpData['album_lang_index'][$key],
            'audio_cover' => "http://img.wtsongs.com/images/albums/" . $fpData['album_title'][($key*2)+1] . "/" . $fpData['album_img_name'][($key*2)+1] . "_80x80.jpg"
            );
        ?>

          <!-- json data -->
          <span class="jsontrack row<?php echo $fpData['track_id'][($key*2)+1]; ?>" style="display:none;"><?php echo json_encode($jsonData); ?></span>

          <div class="song_player play_album track_player" dataClass="<?php echo $fpData['track_id'][($key*2)+1]; ?>"></div>
          <div class="song_name">
              <a href="#"><?php echo $fpData['track_title'][($key*2)+1]; ?></a>
          </div>
          <div class="song_movie_name dotes">
          <?php
          $art_parts = explode(",", $fpData['track_artist'][($key*2)+1]);
          foreach ($art_parts as $artkey => $artvalue) {
            $art = strtolower(str_replace(' ', '+', $art_parts[$artkey]));
            if( substr($art, 0, 1) == "+" )
              $art = substr($art, 1);
            echo '<a href="/artist/' . $art . '/" title="' . $art_parts[$artkey] . '" data-pjax="#main" data-push="true" data-target="#main">' . $art_parts[$artkey] . ', </a>';
          }
          ?>
          </div>                  
        </div>
        <hr/>
        <div class="see_all">
          <a href="/playlists/<?php echo $fpData['img_name_array'][$key]; ?>" class="" data-pjax="#main" title="<?php echo $fpData['img_name_array'][$key]; ?>" data-push="true" data-target="#main">
            <div class="see_all_button"><p>See all</p></div>
          </a>
        </div>
      </div>
    </div>
      <!--2-->
    <?php } ?>
    <?php if(defined('pagination_data')) { unset($this->next); } ?>
    <div class="pagination_container">
    <center>
      <div class="pagination_container_inner"></div>
    </center>
  </div>
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