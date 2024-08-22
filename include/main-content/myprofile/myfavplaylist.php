<?php

    $bodySql = "SELECT pl.playlist_id, pl.playlist_title, u.name FROM wt_playlists AS pl, wt_users AS u, wt_playlist_data AS pd WHERE pl.user_id='$this->user_id' AND pl.user_id=u.id GROUP BY pl.playlist_id LIMIT $this->start, $this->limit";
    $bodyResult = mysqli_query( $GLOBALS['link'], $bodySql );
    if( mysqli_num_rows($bodyResult) > 0 ) {
      while( $bdRow = mysqli_fetch_assoc($bodyResult) ) {
        $bd['album_id'][] = $bdRow['playlist_id'];
        $bd['album_title_without_year'][] = $bdRow['playlist_title'];
        $bd['album_title_with_year'][] = $bdRow['playlist_title'];
        $bd['album_artist'][] = $bdRow['name'];
      }

      //image detection script
      foreach( $bd['album_id'] as $value ) {

        $albumSql = mysqli_query( $GLOBALS['link'], "SELECT al.album_title FROM wt_playlist_data AS pd, wt_tracks as t, wt_albums AS al WHERE pd.playlist_id='$value' AND t.track_id=pd.track_id AND t.album_id=al.album_id LIMIT 1 " );
        if( mysqli_num_rows($albumSql) > 0 ) {

          while( $bdRow = mysqli_fetch_assoc( $albumSql ) ) {

            $bd['album_img_with_year'][] = $bdRow['album_title'];
            $albumYearCheck = substr($bdRow['album_title'], -4);

            if( is_numeric($albumYearCheck) ) {
              $bd['album_img_without_year'][] = substr( $bdRow['album_title'], 0, -5 );
            } else $bd['album_img_without_year'][] = $bdRow['album_title'];
          }

        } else {
          $bd['album_img_with_year'][] = "";
          $bd['album_img_without_year'][] = "";
        }
      }



      $imgArray = str_replace(' ', '+', $bd['album_img_with_year']);
      $imgArray2 = str_replace(' ', '+', $bd['album_img_without_year']);
      $album_url = str_replace(' ', '+', $bd['album_title_without_year']);
      $bd['album_url'] = array_map('strtolower', $album_url);
      $bd['data_path_url'] = array( 'album' => "/playlists/$this->user_name/", 'artist' => "" );

      foreach ($imgArray as $key => $value) {
        $bdLetter = substr($value, 0, 1);
        if(is_numeric($bdLetter)) {
          $bdLetter = "0-9";
        }
        $images = "http://img.wtsongs.com/images/albums/$bdLetter/" . $bd['album_img_with_year'][$key] . "/" . $imgArray[$key] . "_175x175.jpg";
          $images2 = "http://img.wtsongs.com/images/all/$bdLetter/" . $imgArray[$key] . ".jpg";
          $images3 = "http://img.wtsongs.com/images/all/$bdLetter/" . $imgArray2[$key] . ".jpg";
          if(@getimagesize($images)) {
            $img[] = $images;
          } elseif(@getimagesize($images2)) {
            $img[] = $images2;
          } elseif(@getimagesize($images3)) {
            $img[] = $images3;
          } else {
            $img[] = "http://img.wtsongs.com/images/static/song_default_175x175.jpg";
          }
        }

        $bd['img_array'] = array_map('strtolower', $img);

        unset( $imgArray, $imgArray2, $img, $album_url, $albumSql );

        return array( $bd );
    } else header('Location: /');

?>