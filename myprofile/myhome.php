<?php
$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . "/include/controller/class/class.top.php";
require_once $rootDir . "/include/controller/common/common_class.php";
require_once $rootDir . '/include/controller/db/DBConfig.php';
$top = new top_of_page();
$common_class = new commonClass();
include $rootDir . "/include/controller/class/class.generic.php";
$generic = new generic_class();
?>
<!DOCTYPE html>
<html>
<?php

/*
* Logged_in user going to access his own profile or maybe another user profile
*/

if( logged_in == true && isset($_GET['category']) ) {
  $catArray = array( "$top->user_name", "mysong", "myplaylists", "myalbums", "myfavplaylists", "mysettings" );
  if( isset($_GET['category']) ) {
    if( $_GET['category'] !== "" ) {
      $cat = $_GET['category'];
    } else {
      $cat = $top->user_name;
    }
    if( in_array($cat, $catArray) ) {
      require_once root_dir . "/include/controller/class/class.user_content.php";
      $content = new userContent();
      $content->LoadContent($cat);
    } else {
      scriptAlert("Sorry! Wrong category selected");
      goto_errorpage();
    } 
  }
}

/*

*  Any user going to access user profile

*/

elseif( isset($_GET['user']) && $_GET['user'] !== "" ) {
  //user_config
  require_once $rootDir . "/include/controller/class/class.user_config.php";
  $user_stuff = new user_config();
  $user_stuff->display_stuff( $_GET['user'], $common_class );
  require_once root_dir . "/include/controller/class/class.user_content.php";
  $content = new userContent();
  $cat_type_arr = array( "myplaylists", "mysongs", "myalbums", "myfavplaylists" );
  if( isset($_GET['cat_type']) && in_array($_GET['cat_type'], $cat_type_arr) ) {
    $cat = $_GET['cat_type'];
  } else $cat = "myplaylists";
  $content->LoadContent($cat);  
} else {
  scriptAlert("Please login to access your all profiles and content feature!");
  goto_errorpage();
} 


?>
  <div id="modal" class="modal"><!-- Place at bottom of page --></div>
  </body>
</html>