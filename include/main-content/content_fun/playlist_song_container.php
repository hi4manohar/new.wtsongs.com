<div class="album_songs_containner">
<div class="transparent_img" style="background-image: url(&quot;<?php echo $this->pAlbumImg; ?>&quot;);"></div>
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
    <?php
    list( $plData ) = $this->plTrackSql();
    if( isset($plData) ):
    ?>
    <?php
    if( logged_in ) {
      include root_dir . '/include/controller/ajax/internal_check_favourite.php';
      $fav_track = checkfav( $plData['track_id'] );
    }
    ?>
    <?php foreach ($plData['track_title'] as $key => $value) { ?>
    <div class="album_track col<?php echo $plData['track_id'][$key]; ?>">
      <ul class="album_track_inner">
        <li class="track_name">
          <?php
            $jsonData = array(
              'id' => $plData['track_id'][$key],
              'trackTitle' => $value,
              'fp_title' => plTitle,
              'albumId' => $plData['album_id'][$key],
              'albumTitle' => $plData['album_name_with_year'][$key],
              'artist' => $plData['artist_name'][$key],
              'album_lang' => $plData['track_al_lang'][$key],
              'audio_cover' => "http://img.wtsongs.com/images/albums/" . $plData['album_name_with_year'][$key] . "/" . $plData['track_album_img'][$key] . "_80x80.jpg",
              'trackShareUrl' => "http://www.wtsongs.com/song/" . $plData['song_url'][$key]
            );
          ?>
          <span class="jsontrack row<?php echo $plData['track_id'][$key]; ?>" style="display:none;"><?php echo json_encode($jsonData); ?></span>

            <div class="track_player play_album" dataClass="<?php echo $plData['track_id'][$key]; ?>" numberTrack="<?php echo ($key+1) ?>"></div>
          <a href="/song/<?php echo $plData['song_url'][$key]; ?>" title="<?php echo $value; ?>" data-push="true" data-target="#main">
            <p class="name dotes"><?php echo $value; ?></p>
          </a>
          <a href="/album/<?php echo $plData['album_url'][$key]; ?>" data-pjax="#main" data-push="true" data-target="#main"><h3 class="dotes"><?php echo $plData['album_name_without_year'][$key]; ?></h3></a>
        </li>
        <li class="artits_name">
          <div class="dotes float">
          <?php
          $art_parts = explode(",", $plData['artist_name'][$key]);
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
          <progress class="progress_bar" value="<?php echo $plData['track_play_hits'][$key]; ?>" max="10"></progress>
        </li>
        <!-- action part -->
        <?php 
        if(defined('plediting')) {
          require root_dir . "/include/main-content/content_fun/edit_playlist_action.php";
        } else { ?>
        <li class="actions">
          <div class="action_containner">
            <a href="/song/<?php echo $plData['song_url'][$key]; ?>/album/<?php echo $plData['album_url'][$key]; ?>" data-pjax="#main" data-push="true" data-target="#main">
            <div class="downloads_icon downloadsIcon downloadHandle">
              <span class="button-round" title="Download Song" data-type="download" data-value="song<?php echo $plData['track_id'][$key]; ?>"></span>
            </div>
            </a>
            <div class="addto_playlist addToIcons">
              <a href="javascript:void(0);" title="add to playlist"></a>
              <div class="add_option_container none">
                <div class="pop_up_containner">
                  <div class="pop_up"></div>
                </div>
                <a href="javascript:void(0)" title="add to playlist" class="addtoplaylist addtoplaylist<?php echo $plData['track_id'][$key]; ?>" data-value="song<?php echo $plData['track_id'][$key]; ?>" data-type="addtoplaylist" data-cat="song">Add To Playlist</a>
                <a href="javascript:void(0)" title="add to queue" class="addtoqe addtopqe<?php echo $plData['track_id'][$key]; ?>" data-value="song<?php echo $plData['track_id'][$key]; ?>" data-type="addtoqe" data-cat="song">Add To Queue</a>
              </div>
            </div>
            <div class="more_icon moreIcons">
              <a href="javascript:void(0)" title="more"></a>
              <div class="more_option_container none">
                <div class="more_pop_up_containner">
                  <div class="more_pop_up"></div>
                </div>
                <a href="javascript:void(0)" title="share" class="m_f sharesong" data-value="song<?php echo $plData['track_id'][$key]; ?>" data-type="share">
                  <figcaption class="favorite1">Share</figcaption>
                </a>
                <a class="m_s favourite addtofavourite song<?php echo $plData['track_id'][$key]; if( isset($fav_track) ) echo " " . $fav_track[$plData['track_id'][$key]]; ?>" href="javascript:void(0)" title="add to favorite" data-value="song<?php echo $plData['track_id'][$key]; ?>" data-type="favourite" data-cat="song">
                  <figcaption class="figcaption">favorite</figcaption>
                </a>                  
              </div>
            </div>
          </div>
        </li>
        <?php } ?>
      </ul>
    </div>
    <?php } endif; ?>
  </div>
</div>