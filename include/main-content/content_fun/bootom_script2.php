<script src="/assets/js/jquery-1.7.2/jquery-1.7.2.js"></script>
<!-- jquery ui custom 1.8.21 -->
<script type="text/javascript" src="/assets/js/jquery-ui-1.8.21/jquery-ui-1.8.21.custom.min.js"></script>
<!-- facebook login -->
<script type="text/javascript" src="/assets/js/fb_login/fb_login.js"></script>
<!-- Modernizer -->
<script type="text/javascript" src="/assets/js/vendor/modernizr-2.6.2.min.js"></script>
<!-- customjs -->
<script src="/assets/js/main.js"></script>
<!-- ajax handler -->
<script type="text/javascript" src="/assets/js/ajax_handler&popup.js"></script>
<script type="text/javascript" src="/assets/js/ajax_handler&popup1.js"></script>
<script type="text/javascript" src="/assets/js/update_hits.js"></script>
<!-- social share -->
<script type="text/javascript" src="/assets/js/social_share.js"></script>
<!-- editdeletetrack -->
<script type="text/javascript" src="/assets/js/edit_delete_playlist.js"></script>
<!-- audioplayer -->
<script src="/assets/js/audioplayer2.js"></script>
<!-- customajax -->
<script type="text/javascript" src="/assets/js/customloginsignup.js"></script>
<!-- static pages style -->
<script type="text/javascript" src="/assets/js/static_content.js"></script>
<!-- pjax -->
<script type="text/javascript" src="/assets/js/pjax/jquery.pjax.js"></script>
<script type="text/javascript" src="/assets/js/pjax/script.js"></script>
<!-- sweetalert -->
<script type="text/javascript" src="/assets/js/sweetalert/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="/assets/js/sweetalert/sweetalert.css">
<!-- custom scroll -->
<link rel="stylesheet" href="/assets/js/customscroll/jquery.mCustomScrollbar.css" />
<script src="/assets/js/customscroll/jquery.mCustomScrollbar.js"></script>
<!-- simplr smooth scroll -->
<script src="/assets/js/mousewheel/jquery.mousewheel.js" type="text/javascript"></script>
<!-- audiojs -->
<script src="/assets/js/audiojs/audio.min.js"></script>
<!-- rssb-share -->
<script type="text/javascript" src="/assets/js/rssb-share/rrssb.js"></script>
<script>
$(document).ready(function(){
  $(".customscroll").mCustomScrollbar();
  $(".about_his").mCustomScrollbar();
  $('.p_p_content').mCustomScrollbar();
  //check if audio player is displaying or not
  if( !$('.fixed_player_wrapper').length ) {
    $('.footer_nav').css('margin-bottom', '0px');
    paginationTriggerBottom = "413px";
  } else {
    paginationTriggerBottom = "491px";
  } 
  //audiojs
  audiojs.events.ready(function() {
    var as = audiojs.createAll();
  });
});

//analytics
/*
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-61453828-1', 'auto');
  ga('send', 'pageview');
*/
</script>