<?php

class albumContent {

  public $alImage;
  public $alTitleWithoutYear;
  public $alTitleWithoutYearImage;
  public $alId;
  public $alLang;
  public $alFirstLetter;
  public $al_genre;
  public $al_header_img;

  function albumContentCotainer() {

    $this->alImage = strtolower( str_replace(' ', '+', alTitle) );
    $this->alFirstLetter = substr(alTitle, 0, 1);

    //remove year for header
    $alTitleCheck = substr(alHeadTitle, -4);
    if(is_numeric( $alTitleCheck )) {
      $this->alTitleWithoutYear = substr(alHeadTitle, 0, -5);
    } else {
      $this->alTitleWithoutYear = alHeadTitle;
      $alTitleCheck = 2014;
    }

    $this->albumHeader();
    $this->al_song_content();
    $return_data = array(
      'genre' => $this->al_genre,
      'year' => $alTitleCheck,
      'plus_year' => $alTitleCheck+1,
      'language' => $this->alLang
    );
    return $return_data;

  }

  function alHeaderSql() {
    $headeSql = "SELECT t.artist_name, al.last_updated_on, al.album_id, l.lang_title, al.release_year, gn.genre_title, COUNT(`artist_name`) as tt 
FROM wt_tracks as t, wt_albums as al, wt_lang as l, wt_genre as gn
WHERE al.album_title = '" . alTitle . "' AND al.album_id = t.album_id AND al.lang_id=l.lang_id AND al.genre_id=gn.genre_id LIMIT 1";
    $headerSqlResult = mysqli_query( $GLOBALS['link'], $headeSql );
    if( mysqli_num_rows( $headerSqlResult ) > 0 ) {
      while( $dataRow = mysqli_fetch_assoc( $headerSqlResult ) ) {
        $this->alId = $dataRow['album_id'];
        $this->alLang = $dataRow['lang_title'];
        $this->al_genre = $dataRow['genre_title'];

        $header['artist'][] = $dataRow['artist_name'];
        $header['released'][] = $dataRow['last_updated_on'];
        $header['total_track'][] = $dataRow['tt'];
        $header['rlease_year'][] = $dataRow['release_year'];
      }

      //update hits
      global $common, $generic;
      $hits_result = $common->update_a_or_pl_hits( $this->alId, "album" );
      if( $hits_result !== true ) {
        echo "cannot update hits";
      }

      $header['header_image'] = $generic->get_images( "album", alTitle, "_175x175" );

      $favSql = mysqli_query( $GLOBALS['link'], "SELECT * FROM wt_usermeta as u WHERE u.object_id='$this->alId' AND u.term_id='27' AND is_fav='1'" );

      $header['total_fav'] = ( !mysqli_num_rows( $favSql ) > 0 ) ? "Be First to Make it " : mysqli_num_rows( $favSql ) ;

      //for background_img
      $this->al_header_img = $header['header_image'];

      unset( $alImg, $alImg3, $alImg2, $favSql, $headeSql );

      return array( $header );
    }

  }

  function alTrackSql() {
    $al_t_sql = "SELECT t.track_id, t.track_title, t.artist_name, t.play_hits FROM wt_tracks as t, wt_albums as al WHERE al.album_title = '" . alTitle . "' AND al.album_id = t.album_id";

    $al_t_result = mysqli_query( $GLOBALS['link'], $al_t_sql );

    if( mysqli_num_rows( $al_t_result ) > 0 ) {
      while( $tDataRow = mysqli_fetch_assoc( $al_t_result ) ) {

        $alTrack['track_id'][] = $tDataRow['track_id'];
        $alTrack['track_title'][] = $tDataRow['track_title'];
        $alTrack['track_artist'][] = $tDataRow['artist_name'];
        $alTrack['play_hits'][] = $tDataRow['play_hits'];

      }
      $alTrack['song'] = str_replace(' ', '+', $alTrack['track_title']);
      $alTrack['song_url'] = array_map('strtolower', $alTrack['song']);
      return array( $alTrack );
    }
  }

  function albumHeader() {

?>

<div class="album_header_containner">
  <div class="album_containner_inner">
    <div class="album_containner_inner_img">
      <?php list( $headerData ) = $this->alHeaderSql(); ?>
      <img src="<?php echo $headerData['header_image']; ?>">
    </div>
    <a href="javascript:void(0);">
      <div class="album_player albumPlayerIcon"></div>
    </a>
    <div class="album_containner_details">
      <div class="album_details">
        <p class="album_name dotes"><?php echo ucwords( $this->alTitleWithoutYear ); ?></p>

        <p class="album_length">Total Tracks: ( <?php echo $headerData['total_track'][0]; ?> Tracks ) | Last Update: <?php $date = date_create( $headerData['released'][0] ); echo date_format($date,"d-m-Y"); ?></p>

        <p class="year album_length">Release Year: <?php echo $headerData['rlease_year'][0]; ?> | Category: <?php echo $this->al_genre; ?></p>

        <p class="album_singer dotes">Featured Artists: 
        <?php
        $art_parts = explode(",", $headerData['artist'][0]);
        foreach ($art_parts as $arkey => $arvalue) {
          $art = strtolower(str_replace(' ', '+', $art_parts[$arkey]));
          if( substr($art, 0, 1) == "+" )
            $art = substr($art, 1);
          echo '<a class="#main" href="/artist/' . $art . '/" title="' . $art_parts[$arkey] . '" data-pjax="#main" data-push="true" data-target="#main">' . $art_parts[$arkey] . ', </a>';
        }
        ?>,</a>  more...</p>
        <p class="album_favorites album_singer"> <?php echo $headerData['total_fav']; ?> Favorites</p>
        <div class="button">
        <?php if( defined('download') && logged_in === true ): ?>
          <div class="subTab downloadButton">
            <li class="downloadbt green">
              <a href="/download?id=<?php echo track_id; ?>" class="">Download this song for free</a>
            </li>
          </div>
        <?php else: ?>
          <div class="download_button downloadIcon downloadHandle">
            <a href="javascript:void(0)" class="button-round" title="Download Song" data-type="download" data-value="album<?php echo $this->alId; ?>"></a>
          </div>
          <div class="comment_button commentIcon">
            <a href="javascript:void(0)" id="comment-btn" class="button-round" title="Go To comment" data-type="comment" data-value="album<?php echo $this->alId; ?>"></a>
          </div>
        <?php endif; ?>
          <div class="favorite favouriteIcon addtofavourite album<?php echo $this->alId; ?>" data-type="favourite" data-cat="album" data-value="album<?php echo $this->alId; ?>" title="add to favourite">
          </div>
          <div class="add addIcon addtoplaylist addtoplaylist<?php echo $this->alId; ?>" data-type="addtoplaylist" data-cat="album" data-value="album<?php echo $this->alId; ?>" title="add to playlist"></div>
          <div class="share shareIcon headershare">
            <a href="javascript:void(0)" title="share" data-type="share" data-value="album<?php echo $this->alId; ?>"></a>
          </div>
        </div>
      </div>
    </div>
    <div class="album_details_right">
      <div class="fb-like" data-href="https://facebook.com/wtsongs2015" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
      <div class="right_notify seogiUI">
        <div class="notif_box">
        <?php
        if( defined('download') && logged_in === true ):
          echo "<p><b>Notification:</b> Currently we are uploading our files to server, so at this time you can only download song in 64k</p>";
        else:
          echo "<p><b>Notification:</b> If you like this website, please help us to reach thousands of people via liking our facebook page.</p>";
        endif;
        ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php

  }

  function al_song_content() {
    include root_dir . "/include/main-content/content_fun/album_song_content.php";
  }

}

?>