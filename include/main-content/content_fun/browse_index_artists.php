<div class="browse_page_container">
<?php
  //handles both searched artists as well as Main artists page
  list( $arData ) = $this->arContainerSql();
  if( isset($arData) ) {
?>
  <div class="browse_page_corousal">
    <?php foreach( $arData['artist_id'] as $key => $value ) { ?>
    <div class="hindi_albums">
      <a href="/artist/<?php echo $arData['artist_url'][$key]; ?>" data-pjax="#main" data-push="true" data-target="#main">
      <div class="hindi_albums_player noChangePlayButton"></div>
      <div class="like_us"></div>
      <div class="hindi_albums_img">
        <img src="<?php echo $arData['img_array'][$key]; ?>" alt="<?php echo $arData['artist_name'][$key] ?>"></img>
      </div>
      </a>
      <div class="hindi_albums_movies_details">
        <div class="hindi_albums_movie_name middleText">
          <a href="/artist/<?php echo $arData['artist_url'][$key]; ?>/" title="<?php echo $arData['artist_name'][$key]; ?>" data-pjax="#main" data-push="true" data-target="#main"><?php echo $arData['artist_name'][$key]; ?></a>
          <!-- <div class="hindi_albums_artist"></div> -->
        </div>                  
      </div>
    </div>
    <?php } ?>
    <!-- checking if data request is end -->
    <?php if(defined('pagination_data')) { unset($this->next); } ?>
    <div class="pagination_container">
      <center>
        <div class="pagination_container_inner"></div>
      </center>
    </div>
    <!--page navigation-->
    <?php if (isset($this->next)): ?>
    <div class="innav">
      <a href='<?php echo ($searchedAr) ? page_url : $this->pUrl; ?>&page=<?php echo $this->next?>' data-pjax="#main">Next</a>
    </div>
    <?php endif; ?>
  </div>
  <?php } else echo '<p class="seogiUI" style="padding: 35px 0px; font-size: 20px; color: rgb(153, 153, 153); float: left; text-align: center; width: 100%;">Sorry! No artist is available for this keyword.</p>'; ?>
</div>