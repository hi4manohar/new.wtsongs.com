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
    <?php $css_file = new top_css_file(); $css_file->main_css(); ?>
    <!-- <script src="/assets/js/vendor/modernizr-2.6.2.min.js"></script> -->
    <?php
    include $rootDir . '/include/controller/class/class.page_top_styles.php';
    $topSeo = new pagesTopStyle();
    ?>
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
    <?php $common->top_banner(); ?>
      <div id="main">
        <?php
        $topSeo->index_home();
        $common->homeNav();
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