<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>browse.genre</title>
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <script type="text/javascript" src="/assets/js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/web_new.css">
    <style>
      .left_side_bar ul li.browse {
      border-left: 2px solid #ff9933;
      opacity: 1;
      }
      .browse_page_nav1 li a[title=Genre]{
        color: #fff;
        border-bottom: 3px solid #f00;
      }
      .browse_page_nav2 li a[title=Hindi]{
        color: #fff;
      }
    </style>
    <link rel="stylesheet" href="/assets/css/main.css">
    <script src="/assets/js/vendor/modernizr-2.6.2.min.js"></script>
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
  </head>
  <body>
    <div id="loader-wrapper">
      <div id="loader"></div>
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
      <header class="entry-header" id="entry-header">
        <div class="loader-image">
          <img src="/assets/img/loaderImg2.png" />
        </div>
      </header>
    </div>
    <!-- ========== header part html start ========-->
    <?php require_once '../include/common/top_header.php'; ?>
    <!-- ========== header part html end ========-->
    <div class="main_container">
    <!-- require_once Left Sidear -->
    <?php require_once '../include/common/left_side_bar.php'; ?>
    <!-- require_once Left Sidebar End -->
   <div class="middle_bar_containner">
      <div class="middle_bar">
        <!-- ========== banner  part html start ========-->
        <div class="banner"></div>
        <!-- ========== banner  part html end ========-->
       
        <!-- ===== browse part html start ==== -->
        <div class="browse_page_container">
          <div class="browse_page_nav1">
          <ul>
            <li><a href="#" title="Albums">Albums</a></li>
            <li><a href="#" title="Genre">Genre</a></li>
            <li><a href="#" title="Artist">Artist</a></li>
            <li><a href="#" title="Popular">Popular</a></li>
            <li><a href="#" title="Cast">Cast</a></li>
          </ul>
          </div>
          <div class="browse_page_nav2">
          <ul>
            <li><a href="#" title="Hindi">Bollywood</a></li>
            <li><a href="#" title="Remix">Remix</a></li>
            <li><a href="#" title="PoP">PoP</a></li>
            <li><a href="#" title="Devotional">Devotional</a></li>
            <li><a href="#" title="Instrumental">Instrumental</a></li>
            <li><a href="#" title="Bangli">Ghazal</a></li>
            <li><a href="#" title="Maithili">Hip Hop</a></li>
            <li><a href="#" title="Malayalam">Sufi</a></li>
            <li><a href="#" title="Telugu">Rock</a></li>
          </ul>
          </div>
      
          <div class="browse_page_corousal_top">
            <form name="select" class="select" method="post">
              <select name="list" form="album_form">
                  <option value="Popularity">Popularity</option>
                  <option value="A-Z">A-Z</option>
                  <option value="Release date">Release date</option>
              </select>
            </form>
          </div>
          <div class="browse_page_corousal">
          <div class="browse_content_wrapper">
            
            <?php for ($i = 1; $i <= 20; $i++) { ?>
              <!--1-->
              <div class="hindi_albums">
                <div class="hindi_albums_player play_album"></div>
               
                <div class="hindi_albums_img">
                  <img src="/assets/img/Brothers-2015_175x175.jpg" alt="" />
                </div>
                <div class="hindi_albums_movies_details">

                <div class="hindi_albums_movie_name">
                   <a href="#" title="Brothers">Brothers</a>
                  <div class="hindi_albums_artist">
                    <a href="#" class="singer" title="Vishal Dadlani">Vishal Dadlani sonu nigam</a>
                  </div>
                </div>
                </div>
              </div>

              <?php } ?>
            </div>

          </div>
        <!-- ===== browse part html end ==== -->
        <!-- ==== facebook login part html start -->
        
        <?php require_once '../include/common/footer.php'; ?>
      </div>
      <!-- login form html start -->

      <?php include '../include/common/login_form.php'; ?>
     <?php include '../include/common/sign_up_form.php'; ?>

     </div>
     
     <!-- login form html end -->
      <?php require_once '../include/common/right_side_bar.php'; ?>
    </div>
    <script>window.jQuery || document.write('<script src="/assets/js/vendor/jquery.js"><\/script>')</script>
    <script src="../assets/js/main.js"></script>
  </body>
</html>