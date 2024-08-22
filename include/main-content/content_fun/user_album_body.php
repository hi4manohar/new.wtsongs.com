<div id="userBodyContent">
<div class="browse_page_corousal">
  <?php
  $this->userNav();
  if( $this->cat == "myplaylists" || $this->cat == "myfavplaylists" ) {
    list( $bdData ) = $this->userPlaylistSql();
    if( isset($this->show_create_pl) && $this->show_create_pl === true ):


?>

  <div class="hindi_albums cpImage cplaylist">
    <img src="/assets/img/create_playlist.jpg"></img>
  </div>
<?php
  endif;
  }
  if( $this->cat == "myalbums") list( $bdData ) = $this->userAlbumSql();
  ?>
<div id="userContentContainer">
  <?php
  if( count($bdData) > 0 ) :
  foreach( $bdData['album_id'] as $key => $value ) {
  ?>
  <div class="hindi_albums">
    <a href="<?php echo $bdData['data_path_url']['album'] . $bdData['album_url'][$key]; ?>">
    <div class="hindi_albums_player play_album" data-push="true" data-target="#main"></div>
    <div class="like_us"></div>
    <div class="hindi_albums_img">
      <img src="<?php echo $bdData['img_array'][$key]; ?>" alt="<?php echo $bdData['album_title_with_year'][$key] ?>"/>
    </div>
    </a>
    <div class="hindi_albums_movies_details">
      <div class="hindi_albums_movie_name">
        <a href="<?php echo $bdData['data_path_url']['album'] . $bdData['album_url'][$key]; ?>" title="<?php echo $bdData['album_title_with_year'][$key] ?>" data-push="true" data-target="#main"><?php echo $bdData['album_title_without_year'][$key]; ?></a>
        <div class="hindi_albums_artist">
          <?php
          if( isset($bdData['album_artist_unique']) )
             echo '<a class="singer" href="' . $bdData['data_path_url']['artist'] . $bdData['album_artist_unique'][$key] . '" title="' . $bdData['album_artist'][$key] . '" data-pjax="#main" data-push="true" data-target="#main">' . $bdData['album_artist'][$key] . ', </a>';
          else {
            $art_parts = explode(",", $bdData['album_artist'][$key]);
            foreach ($art_parts as $arkey => $arvalue) {
              $art = strtolower(str_replace(' ', '+', $art_parts[$arkey]));
              if( substr($art, 0, 1) == "+" ) $art = substr($art, 1);
              echo '<a class="singer" href="' . $bdData['data_path_url']['artist'] . $art . '" title="' . $art_parts[$arkey] . '" data-pjax="#main" data-push="true" data-target="#main">' . $art_parts[$arkey] . ', </a>';
            }
          }
          
          ?>
        </div>
      </div>                  
    </div>
  </div>
  <?php } endif; ?>
</div>
  <?php
    if (isset($this->next) && count($bdData) > 0):
      pagination(page_url . "&page=" . $this->next);
    endif;
  ?>
</div>
</div>
  <!--page navigation-->
  