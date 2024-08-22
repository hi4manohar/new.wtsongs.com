<!-- ===== recomended songs html start ================ -->    
<div class="recommended_songs">
  <div class="recommended_heading"><a  class="heading" href="javascript:void(0)" title="new_releases">Recommended Songs</a></div>
  <div class="recommended_corousal">
    <div class="recommended_corousal_inner imageWrapper">
    <?php
    list( $rcData ) = $this->recommendedSql();
    ?>
    <?php foreach( $rcData['pl_title'] as $key => $value ) { ?>
      <!--1-->
      <a class="hitMan" data-type="manHits" data-value="playlist<?php echo $rcData['pl_id'][$key]; ?>" href="/playlists/<?php echo $rcData['url'][$key]; ?>" title="<?php echo $rcData['pl_title'][$key]; ?>" data-pjax="#main" data-push="true" data-target="#main">
      <div class="recommended">
        <div class="recommended_player noChangePlayButton">
        </div>
        <div class="recommended_img">
          <img src="<?php echo $rcData['pl_img'][$key]; ?>" alt="<?php echo $rcData['pl_title'][$key]; ?>" />
        </div>
        <div class="recommended_movies_details">
          <div class="recommended_movie_name">
            <span><?php echo $rcData['pl_title'][$key]; ?></span>
          </div>
        </div>
      </div>
      </a>
    <?php } ?>  
    </div>
    <div class="recommended_left_button controlSlideLeft">
      <div class="recommended_prev_button"><img src="assets/img/prev_arrow.png"></div>
    </div>
    <div class="recommended_right_button controlSlideRight">
      <div class="recommended_next_button"><img src="assets/img/next_arrow.png"></div>
    </div>
  </div>
</div>
<!-- ===== recomended songs html end ================ -->