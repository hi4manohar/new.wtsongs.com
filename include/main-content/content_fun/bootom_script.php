<?php

/*

$script_file = array(
  'jquery-1.7.2' => '/assets/js/jquery-1.7.2/jquery-1.7.2.js',
  'modernizer-2.6.2' =>"/assets/js/vendor/modernizr-2.6.2.min.js",
  'jquery-ui-1.8.21' => "/assets/js/jquery-ui-1.8.21/jquery-ui-1.8.21.custom.min.js",
  'wiselink' => "/assets/js/wiselink/wiselinks-1.2.2.min.js",
  'fb_login_js' => "/assets/js/fb_login/fb_login.js",
  'main_js' => "/assets/js/custom_js/main.js",
  'ajax_handler' => "/assets/js/custom_js/ajax_handler&popup.js",
  'ajax_handler_popup' => "/assets/js/custom_js/ajax_handler&popup1.js",
  'update_hits' => "/assets/js/custom_js/update_hits.js",
  'social_share' => "/assets/js/custom_js/social_share.js",
  'edit_delete_playlist' => "/assets/js/custom_js/edit_delete_playlist.js",
  'static_content' => "/assets/js/custom_js/static_content.js",
  'audio_player' => "/assets/js/custom_js/audioplayer2.js",
  'login_signup' => "/assets/js/custom_js/customloginsignup.js",
  'sweetalert_js' => "/assets/js/sweetalert/sweetalert.min.js",
  'custom_scroll_bar' => "/assets/js/customscroll/jquery.mCustomScrollbar.js",
  'mousewheel_js' => "/assets/js/mousewheel/jquery.mousewheel.js",
  'audio_helper' => "/assets/js/audiojs/audio.min.js",
  'rssb-share_js' => "/assets/js/rssb-share/rrssb.js",
  'infinite_scroll' => "/assets/js/inscroll/jquery-ias.js",
  'unser_img_upload' => "/assets/js/user_image_upload.js",
  'jquery_form' => "/assets/js/jquery.form/jquery.form.js",
  'bottom_ajaxify' => "/assets/js/custom_js/bottom_ajaxify.js"
);
*/

/*

@These all files is for local live server file js
@These files temporarily moved to google drive for managing server response
@These settings did on 27-11-2015

$script_file = array(
  'jquery-1.7.2' => '/assets/js/jquery-1.7.2/jquery-1.7.2.js',
  'wiselink' => "/assets/js/wiselink/wiselinks-1.2.2.min.js",
  'jquery-ui-1.8.21' => "/assets/js/jquery-ui-1.8.21/jquery-ui-1.8.21.custom.min.js",
  'modernizer-2.6.2' =>"/assets/js/vendor/modernizr-2.6.2.min.js",
  'fb_login_js' => "/assets/js/fb_login/fb_login.min.js",
  'main_js' => "/assets/js/custom_js/main.min.js",
  'ajax_handler' => "/assets/js/custom_js/ajax_handler&popup.min.js",
  'ajax_handler_popup' => "/assets/js/custom_js/ajax_handler&popup1.min.js",
  'update_hits' => "/assets/js/custom_js/update_hits.min.js",
  'social_share' => "/assets/js/custom_js/social_share.min.js",
  'edit_delete_playlist' => "/assets/js/custom_js/edit_delete_playlist.min.js",
  'static_content' => "/assets/js/custom_js/static_content.min.js",
  'audio_player' => "/assets/js/custom_js/audioplayer2.min.js",
  'login_signup' => "/assets/js/custom_js/customloginsignup.min.js",
  'sweetalert_js' => "/assets/js/sweetalert/sweetalert.min.js",
  'custom_scroll_bar' => "/assets/js/customscroll/jquery.mCustomScrollbar.min.js",
  'mousewheel_js' => "/assets/js/mousewheel/jquery.mousewheel.min.js",
  'audio_helper' => "/assets/js/audiojs/audio.min.js",
  'rssb-share_js' => "/assets/js/rssb-share/rrssb.min.js",
  'infinite_scroll' => "/assets/js/inscroll/jquery-ias.min.js",
  'unser_img_upload' => "/assets/js/user_image_upload.min.js",
  'jquery_form' => "/assets/js/jquery.form/jquery.form.min.js",
  'bottom_ajaxify' => "/assets/js/custom_js/bottom_ajaxify.min.js"
);
*/

/*

$css_file = array(
  'sweetalert_css' => "/assets/js/sweetalert/sweetalert.css",
  'customscroll_css' => "/assets/js/customscroll/jquery.mCustomScrollbar.css"
);

*/

/*
@following files is for google drive js hosted
*/
$script_file = array(
  'jquery-1.7.2' => 'jquery-1.7.2.js',
  'wiselink' => "wiselinks-1.2.2.min.js",
  'jquery-ui-1.8.21' => "jquery-ui-1.8.21.custom.min.js",
  'modernizer-2.6.2' =>"modernizr-2.6.2.min.js",
  'fb_login_js' => "fb_login.min.js",
  'main_js' => "main.min.js",
  'ajax_handler' => "ajax_handler&popup.min.js",
  'ajax_handler_popup' => "ajax_handler&popup1.min.js",
  'update_hits' => "update_hits.min.js",
  'social_share' => "social_share.min.js",
  'edit_delete_playlist' => "edit_delete_playlist.min.js",
  'static_content' => "static_content.min.js",
  'audio_player' => "audioplayer2.min.js",
  'login_signup' => "customloginsignup.min.js",
  'sweetalert_js' => "sweetalert.min.js",
  'custom_scroll_bar' => "jquery.mCustomScrollbar.min.js",
  'mousewheel_js' => "jquery.mousewheel.min.js",
  'audio_helper' => "audio.min.js",
  'rssb-share_js' => "rrssb.min.js",
  'infinite_scroll' => "jquery-ias.min.js",
  'unser_img_upload' => "user_image_upload.min.js",
  'jquery_form' => "jquery.form.min.js",
  'bottom_ajaxify' => "bottom_ajaxify.min.js"
);


/*

@These all files is for local live server file js
@These files temporarily moved to google drive for managing server response
@These settings did on 27-11-2015

$css_file = array(
  'sweetalert_css,customscroll_css' => "/assets/js/sweetalert/sweetalert.min,custom_scroll_bar.min.css"
);
*/

$css_file = array(
  'sweetalert_css,customscroll_css' => "sweetalert.min,custom_scroll_bar.min.css"
);

foreach ($script_file as $key => $value) {
  echo "
  <script type=\"text/javascript\" src=\"http://www.vicharbindu.com/site-asset/wtsongs/wtsongs_js/$value\"></script>";
}
foreach ($css_file as $key => $value) {
  echo "
  <link rel=\"stylesheet\" href=\"http://www.vicharbindu.com/site-asset/wtsongs/wtsongs_js/$value\" />";
}
?>
<script>
var _gaq=[["_setAccount","UA-61453828-1"],["_trackPageview"]];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
s.parentNode.insertBefore(g,s)}(document,"script"));
</script>