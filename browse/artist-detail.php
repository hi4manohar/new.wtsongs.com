<?php
$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . "/include/controller/class/class.top.php";
$top = new top_of_page();
require_once root_dir . '/include/controller/common/common_class.php';
$common_class = new commonClass();
include $rootDir . "/include/controller/class/class.generic.php";
$generic = new generic_class();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php
    if(isset($_GET['name']) && $_GET['name'] !== "") {
      $art_name = $common_class->testitle($_GET['name']);
      define('artist', $art_name);
      $catArray = array( 'songs', 'albums', 'overview' );
      if( isset($_GET['cat']) ) {
        if( in_array($_GET['cat'], $catArray) ) {
          $cat = $_GET['cat'];
        } else $cat = "overview";
      } else $cat = "overview";
    } else define('artist', 'NA');
    if( artist !== 'NA' ):
      require_once root_dir . '/include/controller/db/DBConfig.php';
      include root_dir . '/include/main-content/artist-detail.php';
      include root_dir . '/include/controller/home/seo-optimized.php';
      $headSeo = new seo();
      $trackData = $headSeo->artistSeo(artist, $cat, $start, $limit);
      $content = new artistsContent();
    endif;
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
      <div id="main">
        <style type="text/css">
          .<?php echo $cat; ?> {
            opacity: 1 !important;
          }
        </style>
        <?php $content->arPage($trackData); ?>
        <?php
        $common->fb_comment();
        if( page_request_type() === true ) {
          if($cat == "songs") $common->infinityScroll( array('.album_songs_containner', '.album_track', '.innav', '.innav a', '3' ) );
          if($cat == "albums") $common->infinityScroll( array('.browse_page_corousal', '.hindi_albums', '.innav', '.innav a', '3' ) );
        }
        ?>

      </div>
      <?php $common->footerBar(); ?>
    </div>

    <?php $common->rightSideBar(); ?>
    <?php if($cat !== "albums") $common->footerPlayer(); ?>
    <?php $common->loginForm(); ?>

  </div>
</div>

<div id="modal" class="modal"><!-- Place at bottom of page --></div>
<?php $common->scriptContainer(); ?>
<?php
if( page_request_type() === false ) {
  if($cat == "songs") $common->infinityScroll( array('.album_songs_containner', '.album_track', '.innav', '.innav a', '3' ) );
  if($cat == "albums") $common->infinityScroll( array('.browse_page_corousal', '.hindi_albums', '.innav', '.innav a', '3' ) );
}

?>

  </body>
</html>

