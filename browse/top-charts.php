<?php
$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . "/include/controller/class/class.top.php";
$top = new top_of_page();
?>
<!DOCTYPE html>
<html>
  <head>    
    <?php
    include root_dir . '/include/controller/home/seo-optimized.php';
    include root_dir . '/include/controller/class/class.page_top_styles.php';
    $headSeo = new seo();
    $topSeo = new pagesTopStyle();
    $headSeo->top_charts();
    ?>
    <link rel="stylesheet" type="text/css" href="/assets/css/web_new.css">
  </head>
  <body>
    <!-- ========== header part html start ========-->
    <?php
    $rootDir =  $_SERVER['DOCUMENT_ROOT'];
    require_once $rootDir . '/include/controller/db/DBConfig.php';
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
      <!-- Include Left Sidear -->
      <?php $common->leftSideBar(); ?>
      <!-- Include Left Sidebar End -->
      <div class="middle_bar_containner">
        <div class="middle_bar">
          <?php $common->top_banner(); ?>
          <div id="main">
            <?php
            $topSeo->top_charts();
            $common->homeNav();
            include $rootDir . '/include/main-content/top-charts.php';
            $topChart = new displayTopCharts();
            $topChart->topCollection();
            ?>
          </div>
          <!-- MiddleBar -->
          <?php $common->footerBar(); ?>
        </div>
        <!-- login form html start -->
        <?php $common->loginForm(); ?>
        <!-- login form html end -->
        <?php $common->rightSideBar(); ?>
        <?php $common->footerPlayer(); ?>
      </div>
    </div>
    <?php $common->scriptContainer(); ?>
    <div id="modal" class="modal"><!-- Place at bottom of page --></div>
  </body>
</html>