<div id="audio_container">
<div class="album_songs_containner">
  <div class="transparent_img" style="background-image: url(&quot;http://img.wtsongs.com/images/playlists/b/best of pretty zinta/best+of+pretty+zinta_175x175.jpg&quot;);"></div>
  <div class="album_songs_containner_inner">

  <?php $this->userNav(); ?>
    
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
    <?php
    if( logged_in ) {
      include root_dir . '/include/controller/ajax/internal_check_favourite.php';
      $fav_track = checkfav( $bdData['track_id'] );
    }
    ?>
    <?php foreach( $bdData['track_id'] as $key=>$value ): ?>
    <div class="album_track">
      <ul class="album_track_inner">
        <li class="track_name">
          <a href="javascript:void(0)">
          <span class="jsontrack row<?php echo $bdData['track_id'][$key]; ?>" style="display:none;">{"id":"<?php echo $bdData['track_id'][$key]; ?>", "trackTitle":"<?php echo $bdData['track_title'][$key]; ?>", "fp_title":"", "albumId":"<?php echo $bdData['album_id'][$key]; ?>", "albumTitle":"<?php echo $bdData['album_title'][$key]; ?>", "artist":"<?php echo $bdData['artist_name'][$key]; ?>", "album_lang":"<?php echo $bdData['lang_title'][$key]; ?>", "audio_cover":"http:\/\/img.wtsongs.com\/images\/albums\/<?php echo $bdData['album_title'][$key]; ?>\/<?php echo $bdData['album_title_url'][$key]; ?>_80x80.jpg", "trackShareUrl":"<?php echo "http://www.wtsongs.com/song/" . $bdData['track_title_url'][$key]; ?>"}</span>
            <div class="track_player play_album" dataClass="<?php echo $bdData['track_id'][$key]; ?>" numberTrack="<?php echo $key; ?>"></div>
            <p class="name dotes"><?php echo $bdData['track_title'][$key]; ?></p>
          </a>
          <a href="/album/<?php echo $bdData['album_title_url'][$key]; ?>" data-push="true" data-target="#main"><h3 class="dotes"><?php echo $bdData['album_name_without_year'][$key]; ?></h3></a>
        </li>
        <li class="artits_name">
          <div class="dotes float">
          <?php
          $art_parts = explode(",", $bdData['artist_name'][$key]);
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
          <progress class="progress_bar" value="<?php echo $bdData['track_playhits'][$key]; ?>" max="10"></progress>
        </li>
        <!-- action part -->
        <li class="actions">
          <div class="action_containner">
            <div class="downloads_icon downloadsIcon downloadHandle">
              <a href="javascript:void(0)" class="button-round" title="Download Song" data-type="download" data-value="song<?php echo $bdData['track_id'][$key]; ?>"></a>
            </div>
            <div class="addto_playlist addToIcons">
              <a href="javascript:void(0);" title="add to playlist"></a>
              <div class="add_option_container none">
                <div class="pop_up_containner">
                  <div class="pop_up"></div>
                </div>
                <a href="javascript:void(0)" title="add to playlist" class="addtoplaylist addtoplaylist<?php echo $bdData['track_id'][$key]; ?>" data-value="song<?php echo $bdData['track_id'][$key]; ?>" data-type="addtoplaylist" data-cat="song">Add To Playlist</a>
                <a href="javascript:void(0)" title="add to queue" class="addtoqe addtopqe<?php echo $bdData['track_id'][$key]; ?>" data-value="song<?php echo $bdData['track_id'][$key]; ?>" data-type="addtoqe" data-cat="song">Add To Queue</a>
              </div>
            </div>
            <div class="more_icon moreIcons">
              <a href="javascript:void(0)" title="more"></a>
              <div class="more_option_container none">
                <div class="more_pop_up_containner">
                  <div class="more_pop_up"></div>
                </div>
                <a href="javascript:void(0)" title="share" class="m_f sharesong" data-value="song<?php echo $bdData['track_id'][$key]; ?>" data-type="share">
                  <figcaption class="favorite1">Share</figcaption>
                </a>
                <a class="m_s favourite addtofavourite song<?php echo $bdData['track_id'][$key]; if( isset($fav_track) ) echo " " . $fav_track[$bdData['track_id'][$key]]; ?>" href="javascript:void(0)" title="add to favorite" data-value="song<?php echo $bdData['track_id'][$key]; ?>" data-type="favourite" data-cat="song">
                  <figcaption class="figcaption">favorite</figcaption>
                </a>                  
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <?php endforeach; ?>
    <?php 
    if (isset($this->next)) {
      $url = page_url . "&page=" . $this->next;
      pagination($url);
    }
    ?>
  </div>
</div>
</div>