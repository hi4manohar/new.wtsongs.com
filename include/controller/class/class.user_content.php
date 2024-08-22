<head>
<?php

class userContent {

  public $ccat;

  public function LoadContent($cat) {
    $this->ccat = $cat;
    $this->headContent();
    $this->bodyCotent();
  }

  function headContent() {
    include root_dir . '/include/controller/home/seo-optimized.php';
    $headSeo = new seo();
    $headSeo->displayHeadSeo();

?>

<link rel="stylesheet" type="text/css" href="/assets/css/web_new.css">

</head>

<?php

  }

  function bodyCotent() {
    global $user_data_show;
    $rootDir =  $_SERVER['DOCUMENT_ROOT'];
    include root_dir . '/include/controller/common/common-container.php';
    $common = new commonBar();
    if( logged_in === true ) $logged = new loggedinContent();
    else $logged = new loggedoutContent();
    $logged->topHeader();

?>

<div class="main_container">
<?php $common->leftSideBar(); ?>
  <div class="middle_bar_containner">
    <div class="middle_bar">
      <?php $common->top_banner(); ?>
      <div id="main">
        <style type="text/css">
          .nav ul li a.<?php echo $this->ccat; ?>{
            color: red;
            opacity: 1;
            border-bottom: 4px solid red;
          }
        </style>
        <?php
        /* conditioning if user is going to access another user profile */
        ( isset($user_data_show) ) ? include root_dir . '/include/main-content/myprofile/userhome.php' : include root_dir . '/include/main-content/myprofile/myhome.php';
        $content = new userMainContent();
        $content->userBody($this->ccat);
        ?>

        <?php
        if( page_request_type() === true ) {
          if( $this->ccat == $GLOBALS['top']->user_name || $this->ccat == "mysongs" ) $common->infinityScroll( array('#audio_container', '.album_track', '.innav', '.innav a', '1' ) );
          if( $this->ccat == "myalbums" || $this->ccat == "myplaylists" ) $common->infinityScroll( array('#userContentContainer', '.hindi_albums', '.innav', '.innav a', '1' ) );
        }
        ?>
      </div>
      <?php $common->footerBar(); ?>
    </div>
    <?php $common->rightSideBar(); ?>
    <?php $common->footerPlayer(); ?>
    <?php $common->loginForm(); ?>
  </div>
</div>
<?php $common->scriptContainer(); ?>
<?php
    if( page_request_type() === false ) {
      if( $this->ccat == $GLOBALS['top']->user_name || $this->ccat == "mysongs" ) $common->infinityScroll( array('#audio_container', '.album_track', '.innav', '.innav a', '1' ) );
      if( $this->ccat == "myalbums" || $this->ccat == "myplaylists" ) $common->infinityScroll( array('#userContentContainer', '.hindi_albums', '.innav', '.innav a', '1' ) );
    }
  }

}

?>