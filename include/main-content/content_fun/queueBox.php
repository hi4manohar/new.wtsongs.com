
<?php

$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . '/include/controller/db/DBConfig.php';

  function alTrackSql( $tId ) {
    $al_t_sql = "SELECT t.track_title, t.artist_name, t.play_hits, t.album_id, al.album_title, l.lang_title FROM wt_tracks as t, wt_albums as al, wt_lang as l WHERE t.track_id='" . $tId . "' AND t.album_id=al.album_id AND al.lang_id=l.lang_id";

    $al_t_result = mysqli_query( $GLOBALS['link'], $al_t_sql );

    if( mysqli_num_rows( $al_t_result ) > 0 ) {
      while( $tDataRow = mysqli_fetch_assoc( $al_t_result ) ) {

        $alTrack['track_title'] = $tDataRow['track_title'];
        $alTrack['track_artist'] = $tDataRow['artist_name'];
        $alTrack['play_hits'] = $tDataRow['play_hits'];
        $alTrack['album_id'] = $tDataRow['album_id'];
        $alTrack['album_title'] = $tDataRow['album_title'];
        $alTrack['lang_title'] = $tDataRow['lang_title'];

      }
      $alTrack['song'] = str_replace(' ', '+', $alTrack['track_title']);
      $alTrack['song_url'] = strtolower($alTrack['song']);
      $alTrack['al_url'] = str_replace(' ', '+', $alTrack['album_title']);
      $alTrack['album_url'] = strtolower($alTrack['al_url']);
      unset( $alTrack['al_url'] );
      return array( $alTrack );
    }
  }

if( isset($_COOKIE['song_id'][0]) ) {

foreach( $_COOKIE['song_id'] as $key => $value ) {
  $trackId = $_COOKIE['song_id'][$key];
  list ($tData) = alTrackSql( $trackId );
?>
<div class="album_track col<?php echo $trackId; ?> qelem">
  <ul class="album_track_inner">
    <li class="track_name">
      <a href="javascript:void(0)">
      <span class="jsontrack row<?php echo $trackId; ?>" style="display:none;">{"id":"<?php echo $trackId ?>", "trackTitle":"<?php echo $tData['track_title']; ?>", "fp_title":"", "albumId":"<?php echo $tData['album_id']; ?>", "albumTitle":"<?php echo $tData['album_title']; ?>", "artist":"<?php echo $tData['track_artist']; ?>", "album_lang":"<?php echo $tData['lang_title']; ?>", "audio_cover":"", "trackShareUrl":"http://www.wtsongs.com/song/<?php echo $tData['track_title']; ?>"}</span>
        <div class="track_player play_album" dataclass="<?php echo $trackId; ?>" numbertrack="<?php echo $key; ?>"></div>
        <p class="name dotes"><?php echo $tData['track_title']; ?></p>
      </a>
      <a href="/album/<?php echo $tData['album_url']; ?>" data-pjax="#main"><h3 class="dotes"><?php echo $tData['album_title']; ?></h3></a>
    </li>
  </ul>
</div>
<?php } } ?>        