<div class="browse_page_container">
<?php
if( defined('catExist') && catExist !== "" ) {
  list( $acData ) = $this->catContentSql();
}
?>
<div class="browse_page_corousal">
  <?php foreach( $acData['album_id'] as $key => $value ) { ?>
  <div class="hindi_albums">
    <a href="<?php echo $acData['album_base_url'][$key] . $acData['album_ur'][$key]; ?>" data-pjax="#main" data-push="true" data-target="#main">
    <!-- <div class="hindi_albums_player noChangePlayButton"></div> -->
    <div class="like_us"></div>
    <div class="hindi_albums_img">
      <img class="img" src="<?php echo $acData['img_array'][$key]; ?>" alt="<?php echo $acData['album_title_with_year'][$key] ?>" />
    </div>
    </a>
    <div class="hindi_albums_movies_details">
      <div class="hindi_albums_movie_name">
        <a href="<?php echo $acData['album_base_url'][$key] . $acData['album_ur'][$key]; ?>" title="<?php echo $acData['album_title_with_year'][$key] ?>" data-pjax="#main" data-push="true" data-target="#main"><?php echo $acData['album_title_without_year'][$key]; ?></a>
        <div class="hindi_albums_artist">
          <?php
          $artist_base_url = ( isset($acData['artist_base_url']) ) ? $acData['artist_base_url'] : "javascript:void(0)";
          $art_parts = explode(",", $acData['artist_name'][$key]);
          foreach ($art_parts as $artkey => $artvalue) {
            $art = strtolower(str_replace(' ', '+', $art_parts[$artkey]));
            if( substr($art, 0, 1) == "+" ) $art = substr($art, 1);
            echo '<a href="' . $artist_base_url . '" class="singer" title="' . $art_parts[$artkey] . '" data-pjax="#main" data-push="true" data-target="#main">' . $art_parts[$artkey] . '</a>,';
          }
          ?>
        </div>
      </div>                  
    </div>
  </div>
  <?php } ?>
  <?php if(defined('pagination_data')) { unset($this->next); } ?>
  <div class="pagination_container">
    <center>
      <div class="pagination_container_inner"></div>
    </center>
  </div>
  <!--page navigation-->
  <?php if (isset($this->next)): ?>
  <div class="innav">
    <a href='<?php echo page_url; ?>&page=<?php echo $this->next?>' data-pjax="#main">Next</a>
  </div>
  <?php endif?>
</div>
</div>