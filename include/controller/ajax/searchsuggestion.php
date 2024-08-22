<?php

$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . '/include/controller/db/DBConfig.php';

if(isset($_GET['sugval'])) {

  $value = $_GET['sugval'];

  //song query
  $songSql = "SELECT t.track_title, t.album_id, al.album_title FROM wt_tracks as t, wt_albums as al where track_title LIKE '%" . $value . "%' AND al.album_id=t.album_id ORDER BY play_hits DESC LIMIT 10";
  $songResult = mysqli_query( $link, $songSql );
  if( mysqli_num_rows($songResult) > 0 ) {
    while ( $songRow = mysqli_fetch_assoc( $songResult ) ) {
      $song['song_title'][] = $songRow['track_title'];
      $song['album_id'][] = $songRow['album_id'];
      $song['album_title'][] = $songRow['album_title'];
    }
    $song['url'] = str_replace(' ', '+', $song['album_title']);
    $song['album_url'] = array_map('strtolower', $song['url']);
  }

  //album query
  $albumSql = "SELECT album_title FROM wt_albums where album_title LIKE '" . $value . "%' AND released = 1 LIMIT 5 ";
  $albumResult = mysqli_query( $link, $albumSql );
  if( mysqli_num_rows( $albumResult ) > 0 ) {
    while ( $albumRow = mysqli_fetch_assoc( $albumResult ) ) {
      $album['album_title'][] = $albumRow['album_title'];
    }
    $album['url'] = str_replace(' ', '+', $album['album_title']);
    $album['album_url'] = array_map('strtolower', $album['url']);
  }
  

  //playlist query
  $plSql = "SELECT playlist_title FROM wt_playlists where playlist_title LIKE '%" . $value . "%' AND released = 1 ORDER BY playlist_title ASC LIMIT 5";
  $plResult = mysqli_query( $link, $plSql );
  if( mysqli_num_rows( $plResult ) ) {
    while ( $plRow = mysqli_fetch_assoc( $plResult ) ) {
      $pl['playlist_title'][] = $plRow['playlist_title'];
    }
    $pl['url'] = str_replace(' ', '+', $pl['playlist_title']);
    $pl['pl_url'] = array_map('strtolower', $pl['url']);
  }

  //artist query
  $arSql = "SELECT artist_name FROM wt_tracks WHERE artist_name LIKE '" . $value . "%' LIMIT 1";
  $arResult = mysqli_query( $link, $arSql );
  if( mysqli_num_rows( $arResult ) > 0 ) {
    $arRow = mysqli_fetch_assoc( $arResult );
    $ar_title = $arRow['artist_name'];
    $single_ar_title = explode(",", $ar_title);
    $ar_url = strtolower( str_replace(' ', '+', $single_ar_title[0]) );
  }

?>
    
    <?php 
    if( !empty( $song['song_title'] ) ) { 
      echo '<div class="songs_suggestion">
              <h4>Songs</h4>
            </div>
    <div class="songs_suggestion_containner">';
      foreach( $song['song_title'] as $skey => $svalue ) {
        echo '<div class="songs_suggestion_item dotes">
                <a href="/album/' . $song['album_url'][$skey] . '" data-pjax="#main" data-push="true" data-target="#main">' . $svalue . '</a>
              </div>';
      }
    }
    ?>
    </div>

    
    <?php
    if( !empty( $album['album_title'] ) ) {
      echo '<div class="albums_suggestion">
              <h4>Albums</h4>
            </div>
      <div class="albums_suggestion_containner">';
      foreach( $album['album_title'] as $akey => $avalue ) {
        echo '<div class="albums_suggestion_item dotes">
                <a href="/album/' . $album['album_url'][$akey] . '" data-pjax="#main" data-push="true" data-target="#main">' . $avalue . '</a>
              </div>';
      }
    }
    ?>
    </div>
    
    <?php
    if( !empty( $pl['playlist_title'] ) ) {
      echo '<div class="playlist_suggestion">
              <h4>Playlist</h4>
            </div>
            <div class="playlist_suggestion_containner">';
      foreach ($pl['playlist_title'] as $pkey => $pvalue) {
        echo '<div class="playlist_suggestion_item dotes">
                <a href="/playlists/' . $pl['pl_url'][$pkey] . '" data-pjax="#main" data-push="true" data-target="#main">' . $pvalue . '</a>
              </div>';
      }
    }
    ?>      
    </div>

    <?php

    if( !empty( $ar_title ) ) {
      echo '<div class="artist_suggestion">
              <h4>Artist</h4>
            </div>
            <div class="artist_suggestion_containner">';

      echo '<div class="artist_suggestion_item dotes">
              <a href="/artist/' . $ar_url . '/" data-pjax="#main" data-push="true" data-target="#main">' . $single_ar_title[0] . '</a>
            </div>';
    }

    ?>
    </div>
<?php

}
?>