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
    if(isset($_GET['lang']) && $_GET['lang'] !== "") {
      $lang = $_GET['lang'];
    } else $lang = "hindi";
    $catArray = array( "albums", "casts", "artists", "genres" );
    $category = (isset($_GET['category']) && $_GET['category'] !== "" && in_array($_GET['category'], $catArray)) ? $_GET['category'] : "albums";
    require_once root_dir . '/include/controller/db/DBConfig.php';
    include root_dir . '/include/controller/home/seo-optimized.php';
    include root_dir . '/include/controller/class/class.page_top_styles.php';
    $headSeo = new seo();
    $headStyle = new pagesTopStyle();
    $headSeo->albumsSeo($lang, $category);
    $curUrl= page_url;
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
      $headStyle->browse_index($lang, $category);
      include $rootDir . '/include/main-content/browse_index.php';
      $content = new albumList();
      $content->browseNav();
      ($category == "genres") ? $common->langNav("", 'genres') : $common->langNav("", 'lang');
      $callContent = $content->alContainer($lang, $category);
      if( page_request_type() === true ) {
        $common->infinityScroll( array('.browse_page_corousal', '.hindi_albums', '.innav', '.innav a', '3' ) );
      }
      
      ?>
    </div>

      <?php $common->footerBar(); ?>
    </div>
      <!-- login form html start -->

      <?php $common->loginForm(); ?>
     
     <?php $common->rightSideBar(); ?>
     <?php $common->footerPlayer(); ?>
  </div> 
</div>
<div id="modal" class="modal"><!-- Place at bottom of page --></div>
<?php $common->scriptContainer(); ?>
<?php
if( page_request_type() === false ) {
  $common->infinityScroll( array('.browse_page_corousal', '.hindi_albums', '.innav', '.innav a', '3' ) );
}

?>
  </body>
</html>

