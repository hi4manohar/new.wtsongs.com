<div class="browse_page_container">
<?php
if( isset($genre_data) && $genre_data === true ):
  list( $acData ) = $this->gnContainerSql();
elseif( !defined( 'usersplaylist' ) ):
  $this->SelectorBar("/access/albums/$this->albumsLang");
  list( $acData ) = $this->alContainerSql();
else:
  //defines for searched playlist and usersplaylist
  list( $acData ) = $this->usersPlContainerSql();
  $user_pl = true;
endif;
  if( isset($acData) ) {
?>
<div class="browse_page_corousal">
  <?php foreach( $acData['album_id'] as $key => $value ) { ?>
  <div class="hindi_albums">
    <a href="<?php echo $acData['album_base_url'][$key] . $acData['album_ur'][$key]; ?>" data-pjax="#main" data-push="true" data-target="#main">
    <div class="hindi_albums_player noChangePlayButton"></div>
    <div class="like_us"></div>
    <div class="hindi_albums_img">
      <img src="<?php echo $acData['img_array'][$key]; ?>" alt="<?php echo $acData['album_title_with_year'][$key] ?>" />
    </div>
    </a>
    <div class="hindi_albums_movies_details">
      <div class="hindi_albums_movie_name">
        <a href="<?php echo $acData['album_base_url'][$key] . $acData['album_ur'][$key]; ?>" title="<?php echo $acData['album_title_with_year'][$key] ?>" data-pjax="#main" data-push="true" data-target="#main"><?php echo $acData['album_title_without_year'][$key]; ?></a>
        <div class="hindi_albums_artist">
          <?php
          $artist_base_url = ( isset($acData['artist_base_url']) ) ? $acData['artist_base_url'] : "/artist/";
          if( isset($user_pl) && $user_pl === true ) {
            echo '<a href="' . $artist_base_url . $acData['artist_name_url'][$key] . '" class="singer" title="' . $acData['artist_name'][$key] . '" data-pjax="#main" data-push="true" data-target="#main">' . $acData['artist_name'][$key] . '</a>,';
          }
          else {
            $art_parts = explode(",", $acData['artist_name'][$key]);
            foreach ($art_parts as $artkey => $artvalue) {
              $art = strtolower(str_replace(' ', '+', $art_parts[$artkey]));
              if( substr($art, 0, 1) == "+" ) $art = substr($art, 1);
              echo '<a href="' . $artist_base_url . $art . '" class="singer" title="' . $art_parts[$artkey] . '" data-pjax="#main" data-push="true" data-target="#main">' . $art_parts[$artkey] . '</a>,';
            }
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
    <a href='<?php echo ( isset($searcPl) && $searcPl == true ) ? page_url : $this->pUrl; ?>&page=<?php echo $this->next?>' data-pjax="#main">Next</a>
  </div>
  <?php endif?>
</div>
  <?php } else echo '<p class="seogiUI" style="padding: 35px 0px; font-size: 20px; color: rgb(153, 153, 153); float: left; text-align: center; width: 100%;">Sorry! No playlist is available for this keyword.</p>'; ?>
</div>