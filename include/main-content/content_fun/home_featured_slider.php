<!-- ====== fetured playlist part html ====== -->
<div class="featured_playlist">
  <div class="corousal_heading"><a href="/playlist/featuredplaylist" title="featured playlist" data-pjax="#main" data-push="true" data-target="#main">Featured playlists</a></div>
  <div class="featured_playlist_corousal">
    <div class="featured_playlist_corousal_inner imageWrapper">
      <!--1-->
      <?php 
      list( $fpData ) = $this->fPlaylistSql();
      ?>
      <?php foreach ($fpData['pl_title_index'] as $key => $value) { ?>
      <div class="fe_playlist">
        <div class="fe_playlist_inner">
          <div class="bollywood_top_50">
            <a href="/playlists/<?php echo $fpData['img_name_array'][$key]; ?>" data-pjax="#main" data-push="true" data-target="#main">
            <div class="bollywood_top_50_img">
              <img src="<?php echo $fpData['full_img_src'][$key]; ?>" alt="<?php echo $fpData['pl_title_index'][$key]; ?>">
            </div>
            </a>           
            <div class="bollywood_top_50_player_img noChangePlayButton"></div>
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
            <!--
            <div class="song_artist dotes">
              <a href="#" class=""> • Rahat Fateh Ali Khan, Mukesh Kumar..</a>
            </div>
            -->
          </div>
          <hr/>
          <div class="see_all">
            <a href="/playlists/<?php echo $fpData['img_name_array'][$key]; ?>" class="" data-pjax="#main" data-push="true" data-target="#main" title="<?php echo $fpData['img_name_array'][$key]; ?>">
              <div class="see_all_button">
                <p>See all</p>
              </div>
            </a>
          </div>
        </div>
      </div>
      <!--2-->
     <?php } ?>
    </div>
    <div class="featured_playlist_left_button controlSlideLeft">
      <div class="prev_button">
        <img src="assets/img/prev_arrow.png">
      </div>
    </div>
    <div class="featured_playlist_right_button controlSlideRight">
      <div class="next_button">
        <img src="assets/img/next_arrow.png">
      </div>
    </div>
  </div>
</div>
<!-- ====== fetured playlist part html end ====== -->