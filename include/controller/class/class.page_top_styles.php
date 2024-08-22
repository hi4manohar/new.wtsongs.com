<?php

class pagesTopStyle {

  function index_playlist() {
?>

<style type="text/css">
  .left_side_bar ul li.playlist {
    border-left: 2px solid #f00;
    opacity: 1;
  }
</style>

<?php
  }

  function featured_playlist_top_style($type) {

?>

    <style>
      .left_side_bar ul li.playlist {
        border-left: 2px solid #f00;
        opacity: 1;
      }
      .playlist_page_nav li a.<?php echo $type; ?>{
        color: #f00;
        border-bottom: 1px solid #f00;
        opacity: 1;
      }
    </style>
    <style type="text/css">
      .entry-header {
        float:right;
        top:-20px;
        left:-50px;
        width: 80%;
        max-width: 978px;
        position: relative;
        z-index: 10001;
      }
    </style>

<?php

  }
  function browse_index($lang, $category) {

    if( isset($_GET['sortby']) == "newreleased"  ) {
      $category = "newreleased";
    }

?>

    <style>
      .left_side_bar ul li.browse {
        border-left: 2px solid #ff9933;
        opacity: 1;
      }
      .browse_page_nav1 li a#<?php echo $category; ?>{
        color: #fff;
        border-bottom: 3px solid #f00;
      }
      .browse_page_nav2 li a.<?php echo $lang; ?>{
        color: #fff;
      }
    </style>

<?php

  }

  function about_us() {

?>

<style type="text/css">
  .left_side_bar ul li.help {
    border-left: 2px solid #ff9933;
    opacity: 1;
  }
</style>

<?php

  }

  function top_charts() {
?>

<style>
.left_side_bar ul li.home {
  border-left: 2px solid #f00;
  opacity: 1;
}
.nav ul li a[title=top_charts]{
  color: #f00;
  border-bottom: 4px solid #f00;
  opacity: 1;
}
</style>

<?php
  }

  function searchPage($category) {

?>

<style>
  .left_side_bar ul li.browse {
    border-left: 2px solid #ff9933;
    opacity: 1;
  }
  .browse_page_nav1 li a#<?php echo $category; ?>{
    color: #fff;
    border-bottom: 3px solid #f00;
  }
  .entry-header {
    float:right;
    top:-20px;
    left:-50px;
    width: 80%;
    max-width: 978px;
    position: relative;
    z-index: 10001;
  }
</style>

<?php

  }

  function album_playlists() {

?>

<style type="text/css">
  .left_side_bar ul li.browse {
    border-left: 2px solid #ff9933;
    opacity: 1;
  }
</style>

<?php

  }

  function popularCategory() {

?>

<style>
  .left_side_bar ul li.category {
    border-left: 2px solid #ff9933;
    opacity: 1;
  }
  .browse_page_nav2 li a[title=Hindi]{
    color: #fff;
  }
</style>

<?php

  }

  function popularSong($category) {

?>
<style>
  .left_side_bar ul li.popular {
    border-left: 2px solid #ff9933;
    opacity: 1;
  }
  .browse_page_nav1 li a[title=<?php echo $category; ?>]{
    color: #fff;
    border-bottom: 3px solid #f00;
  }
  .browse_page_nav2 li a[title=Hindi]{
    color: #fff;
  }
</style>
<?php

  }

  function index_home() {
?>

<style type="text/css">
  .entry-header {
    float:right;
    top:-20px;
    left:-50px;
    width: 80%;
    max-width: 978px;
    position: relative;
    z-index: 10001;
  }
  .left_side_bar ul li.home {
    border-left: 2px solid #f00;
    opacity: 1;
  }
  .nav ul li a[title=overview]{
    color: #f00;
    border-bottom: 4px solid #f00;
    opacity: 1;
  }
  .scroll-pane, .scroll-pane-arrows {
    width: 100%;
    height: 200px;
    overflow: auto;
  }
  .horizontal-only {
    height: auto;
    max-height: 200px;
  }
</style>

<?php

  }
}

?>