<!-- ========== New released part html start ========-->
<div class="new_releases">
  <div class="corousal_heading"><a class="heading" href="javascript:void(0);" title="new_releases">New Releases</a></div>
  <div class="new_releases_corousal">
    <div class="new_releases_corousal_inner imageWrapper">
    <?php
    list( $nrData ) = $this->newReleasesSql();
    ?>
    <?php foreach ($nrData['al_title'] as $key => $value) { ?>
      <a href="/album/<?php echo $nrData['imageName'][$key]; ?>" data-pjax="#main" data-push="true" data-target="#main" title="<?php echo $nrData['al_title'][$key]; ?>">
      <div class="latest">
        <div class="player noChangePlayButton"></div>
          <div class="latest_img">
            <img src="<?php echo $nrData['imgArray'][$key]; ?>" alt="<?php echo $value; ?>" />
          </div>
        <div class="movies_details">
          <div class="movie_name">
            <a href="/album/<?php echo $nrData['imageName'][$key]; ?>" data-pjax="#main" data-push="true" data-target="#main" title="<?php echo $nrData['al_title'][$key]; ?>"><?php echo $value; ?></a>
          </div>
          <div class="artist"><a href="/artist/<?php echo $nrData['artist_url'][$key]; ?>" class="singer" title="<?php echo $nrData['al_artist'][$key]; ?>" data-push="true" data-target="#main"><?php echo $nrData['al_artist'][$key]; ?></a>
          </div>
        </div>
      </div>
      </a>
      <?php } ?>
    </div>
    <div class="left_button controlSlideLeft">
      <div class="prev_button"><img src="assets/img/prev_arrow.png"></div>
    </div>
    <div class="right_button controlSlideRight">
      <div class="next_button"><img src="assets/img/next_arrow.png"></div>
    </div>
  </div>
</div>
<!-- ========== New releases part html end ========-->