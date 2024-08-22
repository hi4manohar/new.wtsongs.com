<div id="audio_container">
<div class="album_songs_containner arBottom">
<div class="transparent_img" style="background-image: url(&quot;<?php echo $this->trackData['artist_img']; ?>&quot;);"></div>
  <div class="album_songs_containner_inner">
    <?php $this->album_identity(); ?>
    <div class="total_songs"><a href="songs" data-pjax="#main" data-push="true" data-target="#main"> <?php echo $this->artistName; ?> Songs (<?php echo $this->trackData['total_track']; ?>)</a></div>
    <?php
    if( logged_in ) {
      include root_dir . '/include/controller/ajax/internal_check_favourite.php';
      $fav_track = checkfav( $this->trackData['track_id'] );
    }
    ?>
    <?php foreach( $this->trackData['track_id'] as $key=>$value ): ?>
    <div class="album_track">
      <ul class="album_track_inner">
        <li class="track_name">
          <a href="javascript:void(0)">

          <?php
            $jsonData = array(
              'id' => $this->trackData['track_id'][$key],
              'trackTitle' => $this->trackData['track_title'][$key],
              'fp_title' => '',
              'albumId' => $this->trackData['album_id'][$key],
              'albumTitle' => $this->trackData['album_title'][$key],
              'artist' => $this->trackData['artist_name'][$key],
              'album_lang' => $this->trackData['lang_title'][$key],
              'audio_cover' => "http://img.wtsongs.com/images/albums/" . $this->trackData['album_title'][$key] . "/" . $this->trackData['album_title_url'][$key] . "_80x80.jpg",
              'trackShareUrl' => "http://www.wtsongs.com/song/" . $this->trackData['track_title_url'][$key]
            );
          ?>
            <span class="jsontrack row<?php echo $this->trackData['track_id'][$key]; ?>" style="display:none;"><?php echo json_encode($jsonData); ?></span>
            <div class="track_player play_album" dataClass="<?php echo $this->trackData['track_id'][$key]; ?>" numberTrack="<?php echo $key; ?>"></div>
            <p class="name dotes"><?php echo $this->trackData['track_title'][$key]; ?></p>
          </a>
          <a href="/album/<?php echo $this->trackData['album_title_url'][$key]; ?>" data-pjax="#main" data-push="true" data-target="#main"><h3 class="dotes"><?php echo $this->trackData['album_name_without_year'][$key]; ?></h3></a>
        </li>
        <li class="artits_name">
          <div class="dotes float">
          <?php
          $art_parts = explode(",", $this->trackData['artist_name'][$key]);
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
          <progress class="progress_bar" value="<?php echo $this->trackData['track_playhits'][$key]; ?>" max="10"></progress>
        </li>
        <li class="actions">
          <div class="action_containner">
            <div class="downloads_icon downloadsIcon">
              <a href="javascript:void(0)" title="download_this_song"></a>
            </div>
            <div class="addto_playlist addToIcons">
              <a href="javascript:void(0);" title="add to playlist"></a>
              <div class="add_option_container none">
                <div class="pop_up_containner">
                  <div class="pop_up"></div>
                </div>
                <a href="javascript:void(0)" title="add to playlist" class="addtoplaylist addtoplaylist<?php echo $this->trackData['track_id'][$key]; ?>" data-value="song<?php echo $this->trackData['track_id'][$key]; ?>" data-type="addtoplaylist" data-cat="song">Add To Playlist</a>
                <a href="javascript:void(0)" title="add to queue" class="addtoqe addtopqe<?php echo $this->trackData['track_id'][$key]; ?>" data-value="song<?php echo $this->trackData['track_id'][$key]; ?>" data-type="addtoqe" data-cat="song">Add To Queue</a>
              </div>
            </div>
            <div class="more_icon moreIcons">
              <a href="javascript:void(0)" title="more"></a>
              <div class="more_option_container none">
                <div class="more_pop_up_containner">
                  <div class="more_pop_up"></div>
                </div>
                <a href="javascript:void(0)" title="share" class="m_f sharesong" data-value="song<?php echo $this->trackData['track_id'][$key]; ?>" data-type="share">
                  <figcaption class="favorite1">Share</figcaption>
                </a>
                <a class="m_s favourite addtofavourite song<?php echo $this->trackData['track_id'][$key]; if( isset($fav_track) ) echo " " . $fav_track[$this->trackData['track_id'][$key]]; ?>" href="javascript:void(0)" title="add to favorite" data-value="song<?php echo $this->trackData['track_id'][$key]; ?>" data-type="favourite" data-cat="song">
                  <figcaption class="figcaption">favorite</figcaption>
                </a>                  
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <?php endforeach; ?>
    <?php if( $this->cat == "songs" ): ?>
    <div class="pagination_container">
      <center>
        <div class="pagination_container_inner"></div>
      </center>
    </div>
    <!--page navigation-->
    <?php if (isset($this->next)): ?>
    <div class="innav">
      <a href='<?php echo page_url; ?>&page=<?php echo $this->next?>'></a>
    </div>
    <?php endif; ?>
    <?php endif; ?>
  </div>
  <?php if( $this->cat == "overview" ) $this->arOverviewAlbum(); ?>
</div>
</div>