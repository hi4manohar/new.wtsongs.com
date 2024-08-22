<?php
$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . "/include/controller/class/class.top.php";
require_once $rootDir . "/include/controller/common/common_class.php";
require_once $rootDir . '/include/controller/db/DBConfig.php';
$top = new top_of_page();
$commonphp = new commonClass();
include $rootDir . "/include/controller/class/class.generic.php";
$generic = new generic_class();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php
      if( isset($_GET['category']) ) {
        $cat = $commonphp->testitle( $_GET['category'] );
        $catExist = $commonphp->execute_query( "SELECT * FROM wt_terms WHERE name='" . $cat . "'" );
        if( mysqli_num_rows( $catExist ) == 1 ) {
          $catResult = mysqli_fetch_assoc($catExist);
          define( 'catId', $catResult['term_id'] );
          define( 'catExist', $cat );
          $frontContent = array(
            'stars' => 'Music Artists, Singers, and Songs of Bollywood Stars'
            );
        } else goto_errorpage();
      } else {
        define( 'catExist', "" );
      }
      include $rootDir . '/include/controller/home/seo-optimized.php';
      include $rootDir . '/include/controller/class/class.page_top_styles.php';
      $headSeo = new seo();
      $headSeo->popularCategorySeo();
      $inlineSeo = new pagesTopStyle();
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

  <?php $common->leftSideBar(); ?>

  <div class="middle_bar_containner">
    <div class="middle_bar">
    <?php $common->top_banner(); ?>
    <div id="main">
      <?php $inlineSeo->popularCategory(); ?>
      <div class="category_page_container">
        <div class="category_page_heading">
          <a  class="heading" href="javascript:void(0)" title="discover_album">Category:</a>
          <a class="heading"><?php echo ( isset($frontContent[catExist]) ) ? $frontContent[catExist] : ""; ?></a>
        </div>
        <?php
          include $rootDir . '/include/main-content/popularcategory.php';
          $content = new popularcategoryContent(  );
          $content->pcContent();
        ?>
      </div>
      <?php
      if( page_request_type() === true ) {
        $common->infinityScroll( array('.browse_page_container', '.hindi_albums', '.innav', '.innav a', '3' ) );
      }
      ?>
    </div>       
      <?php $common->footerBar(); ?>
    </div>
    <?php $common->rightSideBar(); ?>
    <?php $common->footerPlayer(); ?>
    <?php $common->loginForm(); ?>
    <!-- login form html end -->
  </div>
</div>    
    <div id="modal" class="modal"><!-- Place at bottom of page --></div>
<?php $common->scriptContainer(); ?>
<?php
if( page_request_type() === false ) {
  $common->infinityScroll( array('.browse_page_container', '.hindi_albums', '.innav', '.innav a', '3' ) );
}

?>
  </body>
</html>

