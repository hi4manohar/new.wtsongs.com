<?php

require_once './config.php';
if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] != "") {
  // user already logged in the site
  header("location:".SITE_URL . "home.php");
}
?>
  
  <?php if ($_SESSION["e_msg"] <> "") { ?>
    <div class="alert alert-dismissable alert-danger">
      <button data-dismiss="alert" class="close" type="button">x</button>
      <p><?php echo $_SESSION["e_msg"]; ?></p>
    </div>
  <?php } ?>
    <a class="btn btn-block btn-social btn-google-plus" href="google_login.php">
            <i class="fa fa-google-plus"></i> Login with Google
          </a>
<?php
// unset if after it display the error.
$_SESSION["e_msg"] = "";
?>
<?php
$DB = NULL;
?>