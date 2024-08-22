<?php
$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . "/include/controller/class/class.top.php";
$top = new top_of_page();
include $rootDir . "/include/controller/class/class.generic.php";
$generic = new generic_class();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php
    $typeArray = array("featuredplaylist", "usersplaylist");
    if( isset($_GET['type']) && $_GET['type'] !== "" && in_array($_GET['type'], $typeArray) ) {
      $type = $_GET['type'];
      define('usersplaylist', true);
    } else $type = "featuredplaylist";
    $rootDir =  $_SERVER['DOCUMENT_ROOT'];
    include $rootDir . '/include/controller/home/seo-optimized.php';
    $headSeo = new seo();
    $headSeo->fplaylistSeo();
    require_once $rootDir . '/include/controller/db/DBConfig.php';
    include root_dir . "/include/controller/class/class.page_top_styles.php";
    $topStyle = new pagesTopStyle();
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
      $topStyle->featured_playlist_top_style($type);
      $common->fpTopNav();
      //$common->langNav(baseUrl . "/featuredplaylist/"); ?>
      <!-- Lang Nav -->

      <?php
      if( $type == "featuredplaylist" ):
        include $rootDir . '/include/main-content/playlist_page.php';
        $content = new fpContent();
        $callContent = $content->fpBox('hindi');
      elseif( $type == "usersplaylist" ):
        include root_dir . '/include/main-content/browse_index.php';
        $content = new albumList();
        $callContent = $content->alContainer('hindi', "albums");
      endif;
      if( page_request_type() === true ) {
        $common->infinityScroll( array('.playlist_content_wrapper', '.playlist_main', '.innav', '.innav a', '3' ) );
      }
      ?>
    </div>
        
        <?php $common->footerBar(); ?>
    </div>

      <?php $common->loginForm(); ?>

      <?php $common->rightSideBar(); ?>

      <!-- Footer Player -->
      <?php if( $type == "featuredplaylist" ) $common->footerPlayer(); ?>
      <!-- Footer Player -->

      </div> 
    </div>
<div id="modal" class="modal"><!-- Place at bottom of page --></div>
<?php $common->scriptContainer(); ?>
<?php
if( page_request_type() === false ) {
  $common->infinityScroll( array('.playlist_content_wrapper', '.playlist_main', '.innav', '.innav a', '3' ) );
}
?>
  </body>
</html>