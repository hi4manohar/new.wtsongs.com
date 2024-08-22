<?php

class popularContent {

  public function popularSongContainer() {
    $this->popularSong();
  }

  function popularSongSql() {
    $psSql = "SELECT tr.track_id, tr.track_title, tr.artist_name, tr.album_id, al.album_title, tr.play_hits, l.lang_title FROM wt_tracks as tr, wt_albums as al, wt_lang as l WHERE tr.album_id = al.album_id AND l.lang_id=al.lang_id ORDER BY tr.play_hits DESC LIMIT 20";
    $psResult = mysqli_query( $GLOBALS['link'], $psSql );

    if( mysqli_num_rows( $psResult ) > 0 ) {
      while( $psRow = mysqli_fetch_assoc($psResult) ) {
        $psSong['track_id'][] = $psRow['track_id'];
        $psSong['track_title'][] = $psRow['track_title'];
        $psSong['album_id'][] = $psRow['album_id'];
        $psSong['album_title'][] = $psRow['album_title'];
        $psSong['play_hits'][] = $psRow['play_hits'];
        $psSong['track_artist'][] = $psRow['artist_name'];
        $psSong['lang_title'][] = $psRow['lang_title'];
      }
      $psSong['album_img'] = str_replace(' ', '+', $psSong['album_title']);
      $psSong['album_src'] = array_map('strtolower', $psSong['album_img']);
      $psSong['song_url'] = str_replace(' ', '+', $psSong['track_title']);
      $psSong['song_conf_url'] = array_map('strtolower', $psSong['song_url']);
      unset($psSong['album_img'], $psSong['song_url']);
      return array( $psSong );
    }
  }

  function popularSong() {

?>

<div class="browse_page_corousal_top">
  <div class="play_all"><img src="/assets/img/play_all_button.jpg" title="play all song"/></div></div>
<!-- album part start -->
<div class="album_songs_containner">
  <div class="album_songs_containner_inner">
    <div class="album_identity">
      <ul class="album_identity_inner">
        <li class="identity_name">
          <a href="javascript:void(0)"><span>Songs</span>
            <img src="/assets/img/up_arrow.png"/>
          </a>
        </li>
        <li class="identity_artits_name">
          <a href="javascript:void(0)"><span>Artists</span>
            <img src="/assets/img/up_arrow.png"/>
          </a>
        </li>
        <li class="identity_popularity">
          <a href="javascript:void(0)"><span>Popularity</span>
            <img src="/assets/img/up_arrow.png"/>
          </a>
        </li>
        <li class="identity_actions">
          <a href="javascript:void(0)"><span>Actions</span>
            <img src="/assets/img/up_arrow.png"/>
          </a>
        </li>
      </ul>
    </div>
    <!--1-->
    <?php list( $psSongData ) = $this->popularSongSql(); ?>
    <?php
    if( logged_in ) {
      include root_dir . '/include/controller/ajax/internal_check_favourite.php';
      $fav_track = checkfav( $psSongData['track_id'] );
    }
    ?>
    <?php foreach( $psSongData['track_id'] as $key => $value ) { ?>
    <div class="album_track">
      <ul class="album_track_inner">
        <li class="track_name">
          <a href="javascript:void(0)">
          <?php
            $jsonData = array(
              'id' => $psSongData['track_id'][$key],
              'trackTitle' => $psSongData['track_title'][$key],
              'fp_title' => '',
              'albumId' => $psSongData['album_id'][$key],
              'albumTitle' => $psSongData['album_title'][$key],
              'artist' => $psSongData['track_artist'][$key],
              'album_lang' => $psSongData['lang_title'][$key],
              'audio_cover' => "http://img.wtsongs.com/images/albums/" . $psSongData['album_title'][$key] . "/" . $psSongData['album_src'][$key] . "_80x80.jpg",
              'trackShareUrl' => "http://www.wtsongs.com/song/" . $psSongData['song_conf_url'][$key]
            );
          ?>

            <span class="jsontrack row<?php echo $psSongData['track_id'][$key]; ?>" style="display:none;"><?php echo json_encode($jsonData); ?></span>

            <div class="track_player play_album" dataClass="<?php echo $psSongData['track_id'][$key]; ?>" numberTrack="<?php echo $key; ?>"></div>
            <p class="album_page_track_name dotes"><?php echo $psSongData['track_title'][$key]; ?></p>
          </a>
        </li>
        <li class="artits_name">
          <div class="dotes float">
            <?php

            $art_parts = explode(",", $psSongData['track_artist'][$key]);
            foreach ($art_parts as $arkey => $arvalue) {
              $art = strtolower(str_replace(' ', '+', $art_parts[$arkey]));
              if( substr($art, 0, 1) == "+" )
                $art = substr($art, 1);
              echo '<a class="#main" href="/artist/' . $art . '/" title="' . $art_parts[$arkey] . '" data-pjax="#main" data-push="true" data-target="#main">' . $art_parts[$arkey] . ', </a>';
            }
          ?>
          </div>
        </li>
        <li class="popularity">
          <progress class="progress_bar" value="<?php echo $psSongData['play_hits'][$key] ?>" max="10"></progress>
        </li>
        <!-- action part -->
        <li class="actions">
          <div class="action_containner">
            <div class="downloads_icon downloadsIcon downloadHandle">
              <a href="javascript:void(0)" class="button-round" title="Download Song" data-type="download" data-value="song<?php echo $psSongData['track_id'][$key]; ?>"></a>
            </div>
            <div class="addto_playlist addToIcons">
              <a href="javascript:void(0);" title="add to playlist"></a>
              <div class="add_option_container none">
                <div class="pop_up_containner">
                  <div class="pop_up"></div>
                </div>
                <a href="javascript:void(0)" title="add to playlist" class="addtoplaylist addtoplaylist<?php echo $psSongData['track_id'][$key]; ?>" data-value="song<?php echo  $psSongData['track_id'][$key]; ?>" data-type="addtoplaylist" data-cat="song">Add To Playlist</a>
               <a href="javascript:void(0)" title="add to queue" class="addtoqe addtopqe<?php echo $psSongData['track_id'][$key]; ?>" data-value="song<?php echo $psSongData['track_id'][$key]; ?>" data-type="addtoqe" data-cat="song">Add To Queue</a>
              </div>
            </div>
            <div class="more_icon moreIcons">
              <a href="javascript:void(0)" title="more"></a>
              <div class="more_option_container none">
                <div class="more_pop_up_containner">
                  <div class="more_pop_up"></div>
                </div>
                <a href="javascript:void(0)" title="share" class="m_f sharesong" data-value="song<?php echo $psSongData['track_id'][$key]; ?>" data-type="share">
                  <figcaption class="favorite1">Share</figcaption>
                </a>
                <a class="m_s favourite addtofavourite song<?php echo $psSongData['track_id'][$key]; if( isset($fav_track) ) echo " " . $fav_track[$psSongData['track_id'][$key]]; ?>" href="javascript:void(0)" title="add to favorite" data-value="song<?php echo $psSongData['track_id'][$key]; ?>" data-type="favourite" data-cat="song">
                  <figcaption class="figcaption">favorite</figcaption>
                </a>                  
              </div>
            </div>
          </div>
        </li>
        <!-- action part -->
      </ul>
    </div>
    <?php } ?> 
  </div>
</div>

<?php
  }

}

?>