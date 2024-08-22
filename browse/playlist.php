<?php
$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . "/include/controller/class/class.top.php";
require_once $rootDir . '/include/controller/db/DBConfig.php';
require $rootDir . "/include/controller/class/class.playlist_config.php";
require_once $rootDir . "/include/controller/common/common_class.php";
$top = new top_of_page();
$pl_stuff = new playlist_config();
$common_class = new commonClass();
include $rootDir . "/include/controller/class/class.generic.php";
$generic = new generic_class();

?>
<!DOCTYPE html>
<html>
  <head>
    <?php    
    if(isset($_GET['name']) && $_GET['name'] !== "") {
      $pl_stuff->pl_do_stuff( $_GET['name'], $common_class );
      global $playlist;
    }
    if( isset($_GET['cat']) && $_GET['cat'] == "editplaylists" ) {
      if(logged_in) {
        define('plediting', true);
      } else goto_errorpage();
    }
    include $rootDir . '/include/controller/home/seo-optimized.php';
    $headSeo = new seo();
    $headSeo->playlistSeo(plTitle);
    $trackSeo = $headSeo->plSongMeta($top);
    if( $trackSeo ):

      //main content page
      include $rootDir . '/include/main-content/index_playlist.php';
      $content = new plTrackContainer();
    else:
      goto_errorpage();
      exit();
    endif;
    ?>
    <link rel="stylesheet" type="text/css" href="/assets/css/web_new.css">
    <?php 
    require_once root_dir . "/include/controller/class/class.page_top_styles.php";
    $style = new pagesTopStyle();
    ?>
  </head>
  <body>
<div id="fb-root"></div>
    <!-- ========== header part html start ========-->
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
    <!-- ========== header part html end ========-->
     <div class="main_container">
    <!-- Include Left SideBar -->
    <?php $common->leftSideBar(); ?>
    <!-- Include End Left SideBar -->
    <div class="middle_bar_containner">  
      <div class="middle_bar">
        <?php $common->top_banner(); ?>
        <div id="main">
          <?php
          $style->index_playlist();
          if($trackSeo) $content->plDataDisplay();
          else {
            echo "Data Does Not Exist";
          }
          ( $playlist['comment'] === true ) ? $common->fb_comment() : ""; ?>  
        </div>
        <?php $common->footerBar(); ?>
      </div>
      <?php $common->rightSideBar(); ?>
      <?php $common->footerPlayer(); ?>
      <?php $common->loginForm(); ?>
      </div>
    </div> 
    <div id="modal" class="modal"><!-- Place at bottom of page --></div>
    <?php $common->scriptContainer(); ?>
  </body>
</html>

