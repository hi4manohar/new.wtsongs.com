<?php

class homeContent {  

  public function displayHome() {
    $this->recommended();
    $this->newReleases();
    $this->featuredSlider();
    $this->discoverSlider();
  }

  function recommendedSql() {
    $rc_sql = "SELECT pl.playlist_title, pl.playlist_id FROM wt_playlists as pl, wt_term_taxonomy as tt WHERE tt.term_id=41 AND tt.term_group_id=9 AND pl.playlist_id=tt.taxonomy_id ORDER BY playlist_id DESC LIMIT 18";
    $rc_result = mysqli_query($GLOBALS['link'], $rc_sql);
    //output data of recommended playlist
    if( mysqli_num_rows($rc_result) > 0 ) {
      while( $rc_row = mysqli_fetch_assoc($rc_result) ) {

        $rc_pl['pl_title'][] = $rc_row['playlist_title'];
        $rc_pl['pl_id'][] = $rc_row['playlist_id'];
      }
    }

    //image Data
    $rcImageName = str_replace(" ", "+", $rc_pl['pl_title']);
    foreach ($rcImageName as $key => $value) {
      $rcLetter = substr($value, 0, 1);
      $rcimg = strtolower( str_replace(' ', '%20', "http://img.wtsongs.com/images/playlists/$rcLetter/" . $rc_pl['pl_title'][$key] . "/$value" . "_175x175.jpg") );
      if(@getimagesize($rcimg)) {
        $rcimgArray[] = $rcimg;
      } else $rcimgArray[] = "http://img.wtsongs.com/images/static/song_default_80x80.jpg";
    }

    $rc_pl['pl_img'] = $rcimgArray;
    $rc_pl['url'] = array_map('strtolower', $rcImageName);

    return array( $rc_pl );
  }

  function newReleasesSql() {
    $nr_sql = "SELECT al.album_id, al.album_title, t.artist_name, gn.genre_title FROM wt_albums as al, wt_tracks as t, wt_term_taxonomy as tt, wt_genre as gn WHERE tt.taxonomy_id=al.album_id AND tt.term_id=42 AND tt.term_group_id=27 AND al.album_id=t.album_id AND al.genre_id=gn.genre_id GROUP BY album_id ORDER BY tt.id DESC LIMIT 15";
    $nr_result = mysqli_query($GLOBALS['link'], $nr_sql);
    if( mysqli_num_rows($nr_result) > 0 ) {
      while( $nr_row = mysqli_fetch_assoc($nr_result) ) {
        //remove year from album
        $nr_al_with_year = $nr_row['album_title'];
        $nr['al_with_year'][] = $nr_al_with_year;
        $nr['al_title'][] = substr($nr_al_with_year, 0, -5);
        $nr['al_artist'][] = explode(",", $nr_row['artist_name'])[0];
        $nr['category'][] = $nr_row['genre_title'];
      }
    }

    //image Data
    $nr['artist_url'] = array_map( 'strtolower', str_replace(' ', '+', $nr['al_artist']) );
    $this->generic = $this->set_generic();
    foreach ($nr['al_with_year'] as $value) {
      $nr['imgArray'][] = $this->generic->get_images( "album", $value, "_175x175" );
    } 
    $nr['imageName'] = array_map( 'strtolower', str_replace( ' ', '+', $nr['al_with_year']) );

    return array( $nr );
  }

  //featured playlist query
  function fPlaylistSql() {

    $fp_sql = "SELECT playlist_id, playlist_title, track_id, term_id, track_title, artist_name, album_id, album_title, lang_title, total, tf
FROM (
SELECT p.playlist_id, 
    s.track_id, 
    p.term_id, 
    s.track_title, 
    s.artist_name, 
    p.playlist_title, 
    s.album_id, 
    al.album_title, 
    lg.lang_title,
    (select count(um.meta_id) from wt_usermeta um where um.object_id = p.playlist_id) tf,
    (select count(sr1.track_id) from wt_playlist_data sr1 
     where sr1.playlist_id=p.playlist_id 
     group by sr1.playlist_id) as total,
       @r := IF (@pid = p.playlist_id,
                 IF (@pid := p.playlist_id, @r+1, @r+1),
                 IF (@pid := p.playlist_id, 1, 1)) AS rn
FROM wt_playlists AS p
CROSS JOIN (SELECT @r:=0, @pid:=0) AS vars
INNER JOIN wt_playlist_data AS sr ON p.playlist_id = sr.playlist_id 
    AND p.user_id=0 
    AND p.term_id=9 
    AND p.lang_id=2 
    AND p.released=1
INNER JOIN wt_term_taxonomy AS tt ON tt.taxonomy_id=p.playlist_id AND tt.term_id=43 AND tt.term_group_id=9
INNER JOIN wt_tracks AS s ON sr.track_id = s.track_id
INNER JOIN wt_albums AS al ON s.album_id = al.album_id
INNER JOIN wt_lang AS lg ON al.lang_id = lg.lang_id
ORDER BY tt.taxonomy_id DESC, s.track_id ) AS t
WHERE t.rn <= 2 LIMIT 14";
    $fp_result = mysqli_query( $GLOBALS['link'], $fp_sql );
    //output data of freature playlist
    if( mysqli_num_rows($fp_result) > 0 ) {

      while( $fp_row = mysqli_fetch_assoc($fp_result) ) {
        $fp['playlist_title'][] = $fp_row['playlist_title'];
        $fp['track_title'][] = $fp_row['track_title'];
        $fp['track_artist'][] = $fp_row['artist_name'];
        $fp['track_id'][] = $fp_row['track_id'];
        $fp['album_id'][] = $fp_row['album_id'];
        $fp['album_title'][] = $fp_row['album_title'];
        $fp['album_lang'][] = $fp_row['lang_title'];
        //total_track
        $fp['total_track'][] = $fp_row['total'];
        $fp['tf'][] = $fp_row['tf'];
      }
    } else {
      define('pagination_data', 'end');
    }

    //image Data
    //uniqueness of data
    foreach ($fp['total_track'] as $tkey => $tvalue) {
      if($tkey % 2 == 0) {
        $fp['t_track_index'][] = $fp['total_track'][$tkey];
        $fp['album_lang_index'][] = $fp['album_lang'][$tkey];
        $fp['pl_title_index'][] = $fp['playlist_title'][$tkey];
        $fp['tf_index'][] = $fp['tf'][$tkey];
      }
    }
    unset( $fp['total_track'], $fp['album_lang'], $fp['playlist_title'], $fp['tf'] );
    $fp['img_name'] = str_replace(" ", "+", $fp['pl_title_index']);
    $fp['img_name_array'] = array_map('strtolower', $fp['img_name']);
    unset($fp['img_name']);

    $this->generic = $this->set_generic();

    foreach ($fp['pl_title_index'] as $key => $value) {
      $fp['image_src'][] = $this->generic->get_images( "playlist", $value, "_80x80" );
    }

    $fp['full_img_src'] = array_map('strtolower', $fp['image_src']);
    unset($fp['image_src']);

    $fp['album_img'] = str_replace(' ', '+', $fp['album_title']);
    $fp['album_img_name'] = array_map('strtolower', $fp['album_img']);
    unset($fp['album_img']);

    return array( $fp );
  }

  function set_generic() {
    global $generic;
    return $generic;
  }

  function discoverSql() {
    $dsSql = "SELECT name FROM wt_terms as tm WHERE term_group = 'category' LIMIT 11";
    $dsResult = mysqli_query( $GLOBALS['link'], $dsSql );
    if( mysqli_num_rows( $dsResult ) > 0 ) {
      //output data for each row
      $this->generic = $this->set_generic();
      while( $ds_row = mysqli_fetch_assoc( $dsResult ) ) {
        $ds['content'][] = $ds_row['name'];
        $ds['img'][] = $this->generic->get_images( "playlist", $ds_row['name'], "_150x150" );
      }

      return array( $ds );

    }
  }

  public function recommended() {
    include root_dir . "/include/main-content/content_fun/home_recommended.php";
  }

  public function newReleases() {
    include root_dir . "/include/main-content/content_fun/home_new_release.php";
  }

  public function featuredSlider() {
    include root_dir . "/include/main-content/content_fun/home_featured_slider.php";
  }
  public function discoverSlider() {
    include root_dir . "/include/main-content/content_fun/home_discovered_slider.php";
  }
}

?>