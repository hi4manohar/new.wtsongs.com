<?php
$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . "/include/controller/class/class.top.php";
$top = new top_of_page();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php
    $catArray = array('albums', 'songs', 'playlists', 'artists');
    if( isset($_GET['cat']) && $_GET['cat'] !== "" && in_array($_GET['cat'], $catArray) ) {
      $cat = $_GET['cat'];
      $query = $_GET['q'];
      $query = $top->trimData($query);
      $search = true;
    } else define('search', false);
    $rootDir =  $_SERVER['DOCUMENT_ROOT'];
    require_once $rootDir . '/include/controller/db/DBConfig.php';
    include root_dir . '/include/controller/home/seo-optimized.php';
    include root_dir . '/include/controller/class/class.page_top_styles.php';
    $headSeo = new seo();
    $headSeo->searchSeo();
    $topSeo = new pagesTopStyle();
    ?>
    <link rel="stylesheet" type="text/css" href="/assets/css/web_new.css">
  </head>
  <body>
    <?php
    include $rootDir . '/include/controller/common/common-container.php';
    $common = new commonBar();
    if(logged_in) {
        $logged = new loggedinContent();
    } else {
        $logged = new loggedoutContent();
    }
    $logged->topHeader();
    ?>
<div class="main_container">
  <!-- Include Left SideBar -->
  <?php $common->leftSideBar(); ?>
  <!-- Include End Left SideBar -->
  <div class="middle_bar_containner">   
    <div class="middle_bar">
      <?php $common->top_banner(); ?>
      <div id="main">
        <?php
        if($search) {
          $topSeo->searchPage($cat);
          include root_dir . '/include/main-content/search.php';
          $search = new searchContainer();
          $search->displaySearch($cat, $query);
        }

        if( page_request_type() === true ) {
          if($cat == "albums" || $cat == "artists" || $cat == "playlists") $common->infinityScroll( array('.browse_page_corousal', '.hindi_albums', '.innav', '.innav a', '3' ) );
          elseif( $cat == "songs" ) $common->infinityScroll( array('.album_songs_containner', '.album_track', '.innav', '.innav a', '3' ) );
        }
        
        ?>
      </div>
      <!-- Middle Bar -->
      <?php $common->footerBar(); ?>

    </div>
    <?php $common->rightSideBar(); ?>

    <?php $common->footerPlayer(); ?>

    <!-- login form html start -->
    <?php $common->loginForm(); ?>
    <!-- login form html end -->

  </div>
</div>
<div id="modal" class="modal"><!-- Place at bottom of page --></div>
<?php $common->scriptContainer(); ?>
<?php 
if( page_request_type() === false ) {
  if($cat == "albums" || $cat == "artists" || $cat == "playlists") $common->infinityScroll( array('.browse_page_corousal', '.hindi_albums', '.innav', '.innav a', '3' ) );
  elseif( $cat == "songs" ) $common->infinityScroll( array('.album_songs_containner', '.album_track', '.innav', '.innav a', '3' ) );
}
?>
<?php mysqli_close($link); ?>
  </body>
</html>