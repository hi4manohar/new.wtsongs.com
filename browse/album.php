<?php
$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . "/include/controller/class/class.top.php";
require_once $rootDir . "/include/controller/common/common_class.php";
require_once $rootDir . "/include/controller/db/DBConfig.php";
//album_config
require_once $rootDir . "/include/controller/class/class.album_playlist_config.php";
$common_class = new commonClass();
$top = new top_of_page();
include $rootDir . "/include/controller/class/class.generic.php";
$generic = new generic_class();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php
    $album_params = new album_config();
    if( $album_params->check_query( $common_class ) === true ) {
      $alLetter = substr(alTitle, 0, 1);
    } else goto_errorpage();
    include $rootDir . '/include/controller/home/seo-optimized.php';
    $headSeo = new seo();
    ( (defined('song')) && (song === true) ) ? $headSeo->albumSongSeo() : $headSeo->albumSeo(alTitle);
    $trackSeo = $headSeo->alSongMeta();
    include $rootDir . '/include/main-content/album_playlist.php';
    $content = new albumContent();
    ?>
    <link rel="stylesheet" type="text/css" href="/assets/css/web_new.css">
    <?php
    include $rootDir . '/include/controller/class/class.page_top_styles.php';
    $topSeo = new pagesTopStyle();
    ?>
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
        $topSeo->album_playlists();
        if(!$trackSeo == "not-exist") {
          $callContent = $content->albumContentCotainer();
          ( $callContent ) ? $common->carouselContainer("album", $callContent, $generic) : "";
        } else {
          echo "Data Does Not Exist";
        }
        ?>
        <?php $common->fb_comment(); ?>
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