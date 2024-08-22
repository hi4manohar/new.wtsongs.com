<?php

class popularcategoryContent {

  public function pcContent() {
    if( defined('catExist') && catExist !== "" ) {
      $limit = 18;
      $page = (int) (!isset($_GET['page'])) ? 1 : $_GET['page'];
      # find out query stat point
      $start = ($page * $limit) - $limit;
      # query for page navigation
      $next = ++$page;
      $this->startLimit = $start;
      $this->endLimit = $limit;
      $this->next = $next;
      $this->catContent();
    } else {
      $this->pcategory();
    }    
  }

  function pcCategorySql() {
    $pcSql = "SELECT term_id, name FROM wt_terms where term_group='category'";
    $pcResult = mysqli_query( $GLOBALS['link'], $pcSql );
    if(mysqli_num_rows($pcResult) > 0 ) {
      while( $pcRow = mysqli_fetch_assoc($pcResult) ) {
        $pc['term_id'][] = $pcRow['term_id'];
        $pc['name'][] = $pcRow['name'];
      }
      $imgArray = str_replace(' ', '+', $pc['name']);

      $this->generic = $this->set_generic();
      foreach ($imgArray as $key => $value) {
        $pcLetter = substr($pc['name'][$key], 0, 1);

        $pc['img_url'][] = $this->generic->get_images( "playlist", $pc['name'][$key], "_150x150" );
      }
      $pc['href_url'] = array_map('strtolower', $imgArray);
      return array( $pc );
    }
  }

  function set_generic() {
    global $generic;
    return $generic;
  }

  function catContentSql() {
    $userPlSql = "SELECT pl.playlist_id, pl.playlist_title, (SELECT COUNT(*) FROM wt_usermeta as um WHERE um.object_id=pl.playlist_id AND um.term_id=tt.term_group_id AND um.is_fav=1) as count FROM wt_playlists as pl, wt_term_taxonomy as tt WHERE tt.term_id=" . catId . " AND tt.taxonomy_id=pl.playlist_id GROUP BY playlist_title LIMIT " . $this->startLimit . ", "  . $this->endLimit;
    $userPlResult = mysqli_query( $GLOBALS['link'], $userPlSql );
    if( mysqli_num_rows($userPlResult) > 0 ) {
      $this->generic = $this->set_generic();
      while( $plRow = mysqli_fetch_assoc($userPlResult) ) {
        $ac['album_title_without_year'][] = $plRow['playlist_title'];

        $ac['album_title_with_year'][] = $plRow['playlist_title'];
        $ac['album_id'][] = $plRow['playlist_id'];
        $ac['artist_name'][] = $plRow['count'] . "  Favourites";
        $ac['album_base_url'][] = "/playlists/";

        $ac['img_array'][] = $this->generic->get_images( "playlist", $plRow['playlist_title'], "_175x175" );
      }

      $imgArray = str_replace(' ', '+', $ac['album_title_without_year']);
      $ac['playlist_url'] = str_replace(' ', '+', $ac['album_title_without_year']);
      $ac['album_ur'] = array_map('strtolower', $ac['playlist_url']);

      return array( $ac );
    } else {
      define( 'pagination_data', true );
      goto_errorpage();
      echo 'Page not found!';
      exit();
    }
  }

  function pcategory() {
    include root_dir . '/include/main-content/content_fun/pcategory.php';
  }

  function catContent() {
    include root_dir . '/include/main-content/content_fun/category_content.php';
  }

}

?>