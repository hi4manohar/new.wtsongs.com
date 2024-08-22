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
    include $rootDir . '/include/controller/home/seo-optimized.php';
    $headSeo = new seo();
    $headSeo->displayHeadSeo();
    require_once $rootDir . '/include/controller/db/DBConfig.php';
    ?>
    <!-- <script type="text/javascript" src="/assets/js/jquery.js"></script> -->
    <link rel="stylesheet" type="text/css" href="/assets/css/web_new.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <!-- <script src="/assets/js/vendor/modernizr-2.6.2.min.js"></script> -->
    <style type="text/css">
    .entry-header {
      float:right;
      top:-20px;
      left:-50px;
      width: 80%;
      max-width: 978px;
      position: relative;
      z-index: 10001;
    }
    .left_side_bar ul li.home {
      border-left: 2px solid #f00;
      opacity: 1;
    }
    .nav ul li a[title=overview]{
      color: #f00;
      border-bottom: 4px solid #f00;
      opacity: 1;
    }
    .scroll-pane, .scroll-pane-arrows {
      width: 100%;
      height: 200px;
      overflow: auto;
    }
    .horizontal-only {
      height: auto;
      max-height: 200px;
    }
    </style>
  </head>
  <body>
    <?php $headSeo->defaultLoader(); ?>
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
      <div id="main">
        <!-- ========== banner  part html start ========-->
        <?php $common->top_banner(); ?>
        <!-- ========== banner  part html end ========-->
        <?php $common->homeNav(); ?>
        <?php
        include $rootDir . '/include/main-content/home.php';
        $content = new homeContent();
        $content->displayHome();
        ?>
      </div>
        
    <?php $common->footerBar(); ?>
    </div>
    <!-- MiddleBar -->
    <!-- login form html start -->
    <?php $common->loginForm(); ?>
    <!-- login form html end -->
     
    <?php $common->rightSideBar(); ?>

    <!-- Footer Player -->
    <?php $common->footerPlayer(); ?>
    <!-- Footer Player -->
  </div>
</div>
<div id="modal" class="modal"><!-- Place at bottom of page --></div>
<?php $common->scriptContainer(); ?>
  </body>
</html>