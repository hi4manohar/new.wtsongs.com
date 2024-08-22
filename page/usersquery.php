<?php
$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . "/include/controller/class/class.top.php";
require_once $rootDir . "/include/controller/common/common_class.php";
$top = new top_of_page();
$common_class = new commonClass();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="robots" content="noindex, nofollow, noarchive">
    <title>wtsongs.com</title>
    <?php
    require_once root_dir . '/include/controller/db/DBConfig.php';
    include root_dir . '/include/controller/home/seo-optimized.php';
    $seo_optimized = new seo();
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
        if(isset($_GET['forgotpassword']) && $_GET['forgotpassword'] !== "" && strlen($_GET['forgotpassword']) == 32) {
          if( logged_in == true ) {
            goto_errorpage();
          } else {
            $logged->resetPassForm($_GET['forgotpassword']);
          }
        } elseif( isset($_GET['confirm_reg']) && isset($_GET['email']) && $_GET['email'] !== "" && strlen($_GET['confirm_reg']) == 13 ) {
          $check_exist = $common_class->execute_query("SELECT id FROM wt_users WHERE pass_token='" . $_GET['confirm_reg'] . "' AND email='" . $_GET['email'] . "'");
          if( mysqli_num_rows($check_exist) == 1 ) {
            if( $common_class->query_execute("UPDATE wt_users SET pass_token='active' WHERE email='" . $_GET['email'] . "'") ) {
              echo '<div style="margin-top: 5px; margin-bottom: 20px;" class="thanks_panel">
              <div style="color: rgb(236, 69, 69); text-align: center; font-size: 20px;" class="thank_message">
                Thank You! Now you are registered with wtsongs.com, <br>Now enjoy all type of music on wtsongs.com for free.<br><a href="/">Go to wtsongs.com</a>
               </div>
              </div>';
            }
          } else {
            echo "Link does't exist";
          }
        }
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