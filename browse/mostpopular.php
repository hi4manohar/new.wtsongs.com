<?php
$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . "/include/controller/class/class.top.php";
$top = new top_of_page();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php
    if(isset($_GET['category']) AND $_GET['category'] !== "") {
      $category = $_GET['category'];
    } else $category = "song";
    $rootDir =  $_SERVER['DOCUMENT_ROOT'];
    require_once $rootDir . '/include/controller/db/DBConfig.php';
    include $rootDir . '/include/controller/home/seo-optimized.php';
    $headSeo = new seo();
    $headSeo->playlistSeo($headSeo->plName);
    include $rootDir . "/include/controller/class/class.page_top_styles.php";
    $topStyle = new pagesTopStyle();
    ?>
    <link rel="stylesheet" type="text/css" href="/assets/css/web_new.css">    
    <link rel="stylesheet" href="/assets/css/main.css">
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
  <?php $common->leftSideBar(); ?>
  <div class="middle_bar_containner">
    <div class="middle_bar">
    <?php $common->top_banner(); ?>
      <div id="main">
        <div class="browse_page_container">
          <?php
          $common->popularNav();
          $topStyle->popularSong($category);
          include $rootDir . '/include/main-content/popular-content.php';
          $content = new popularContent();
          $content->popularSongContainer();
          ?>
        </div>
      </div>
      <!-- Main End -->
        <?php $common->footerBar(); ?>
    </div>
      <?php $common->rightSideBar(); ?>
      <?php $common->footerPlayer(); ?>
      <?php $common->loginForm(); ?>
  </div>
  <div id="modal" class="modal"><!-- Place at bottom of page --></div>
<?php $common->scriptContainer(); ?>
  </body>
</html>