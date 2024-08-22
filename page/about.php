<?php
$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . "/include/controller/class/class.top.php";
$top = new top_of_page();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php
    require_once root_dir . '/include/controller/db/DBConfig.php';
    include root_dir . '/include/controller/home/seo-static.php';
    include root_dir . '/include/controller/class/class.page_top_styles.php';
    include root_dir . '/include/controller/home/seo-optimized.php';
    $seo_optimized = new seo();
    $headSeo = new static_seo();
    $headSeo->about_us_seo();
    $headStyle = new pagesTopStyle();
    ?>
    <link rel="stylesheet" type="text/css" href="/assets/css/web_new.css">
  </head>
  <body>

    <?php
    include root_dir . '/include/controller/common/common-container.php';
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
      <div id="main" class="static">
        <?php
        $headStyle->about_us();
        include root_dir . '/include/main-content/content_fun/about.php';
        $content = new static_content();
        $content->about_us_content();
        ?>
      </div>
      <?php $common->footerBar(); ?>
    </div>

    <?php $common->rightSideBar(); ?>
    <?php $common->loginForm(); ?>

  </div>
</div>

<div id="modal" class="modal"><!-- Place at bottom of page --></div>
<?php $common->scriptContainer(); ?>
  </body>
</html>

