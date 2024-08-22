<?php
if(logged_in) {
  include $rootDir . '/include/controller/common/loggedincontent.php';
} else {
  include $rootDir . '/include/controller/common/loggedoutcontent.php';
}
class commonBar {

  public $carouselType;
  public $carousel_genre_id;

  //removed
  public function topHeader() {
    echo '<div class="top_header">';
    $this->topHeaderLogo();
    $this->topHeaderLogin();
    echo '</div>';
  }
  //removeduu

  public function fpTopNav() {
    $this->fpNav();
  }

  public function carouselContainer($type, $data_cat, $generic) {
    $this->carouselType = $type;
    $this->carousel_genre = $data_cat['genre'];
    $this->data_cat = $data_cat;
    $this->generic = $generic;
    $this->carousel();
  }

  public function scriptContainer() {
    $this->bottomScripts();
  }

  public function addtopocontainer() {
    $this->addtopopup();
  }

  function cr_albumSql() {
    //album_cr_query
    $cr_query = "SELECT al.album_id, al.album_title, t.artist_name FROM wt_albums as al, wt_genre as g, wt_tracks as t, wt_lang as l WHERE g.genre_title='" . $this->data_cat['genre'] . "' AND l.lang_title='" . $this->data_cat['language'] . "' AND al.lang_id=l.lang_id AND t.album_id=al.album_id AND al.release_year BETWEEN '" . $this->data_cat['year'] . "' AND '" . $this->data_cat['plus_year'] . "' GROUP BY al.album_id ORDER BY rand() LIMIT 15 ";
    $nr_result = mysqli_query($GLOBALS['link'], $cr_query);
    if( mysqli_num_rows($nr_result) > 0 ) {
      while( $nr_row = mysqli_fetch_assoc($nr_result) ) {
        //new

        $cr_al_with_year = $nr_row['album_title'];
        $crAlbum['album_with_year'][] = $cr_al_with_year;
        $alTitleCheck = substr($cr_al_with_year, -4);

        if(is_numeric( $alTitleCheck )) {
          $crAlbum['album_title'][] = substr($cr_al_with_year, 0, -5);
        } else $crAlbum['album_title'][] = $cr_al_with_year;

        $crArt =  explode(",", $nr_row['artist_name'])[0];
        if( substr($crArt, 0, 1) == " " )
          $crAlbum['album_artist'][] = substr( $crArt, 1 );
        else $crAlbum['album_artist'][] = $crArt;
      }
      $crAlbum['ar_url'] = str_replace(' ', '+', $crAlbum['album_artist']);
      $crAlbum['artist_url'] = array_map('strtolower', $crAlbum['ar_url']);
    } else {
      return false;
    }

    //image Data
    $crImageName = str_replace(" ", "+", $crAlbum['album_with_year']);
    $crAlbum['album_url'] = array_map('strtolower', $crImageName);
    foreach ($crImageName as $key => $value) {
      $album_image[] = $this->generic->get_images( "album", $value, "_175x175" );
    }
    $crAlbum['album_image'] = array_map('strtolower', $album_image);

    unset( $crAlbum['ar_url'], $crImageName );

    return array( $crAlbum );
  }

  public function topHeaderLogo() {
    echo '
      <div class="topLogo">
        <a href="/"><img src="/assets/img/logo.png" title="wtsongs.com"></a>
      </div>
      <div class="formBox">
        <form name="search_form" method="post" id="search_form">
          <input type="text" name="search" placeholder="Search for Music, Albums, Artists, Playlists, Casts,Popular Users ">
        </form>
      </div>';
  }

  public function topHeaderLogin() {
    echo '
      <div class="loginBox">
        <ul>
          <li class="login_icon_container">
            <img class="login_icon" src="/assets/img/login_icon.png">
            <span class="login_text">signin/signup</span>
          </li>
          <li class="free_app_icon_container">
            <img class="free_app_icon" src="/assets/img/mobile_icon.png">
            <span class="mobile_app_text">get free app</span>
          </li>
        </ul>
      </div>';
  }

  function leftSideBar() {
?>
    <!-- ========== left side bar part html start ========-->
    <div class="left_side_bar">
      <ul>
        <li class="home">
          <a class="home_link" href="/" title="Home" data-pjax="#main" data-push="true" data-target="#main">
          <img class="home_icon" src="/assets/img/home_icon.png">
          <span class="home_text">Home</span>
          </a>
        </li>
        <li class="popular">
          <a class="popular_link" href="/mostpopular/" title="mostpopular" data-pjax="#main" data-push="true" data-target="#main">
          <img class="home_icon" src="/assets/img/popular_icon.png">
          <span class="home_text">Popular</span>
          </a>
        </li>
        
        <li class="category">
          <a class="category_link" href="/popularcategory/" title="Popular Categories" data-pjax="#main" data-push="true" data-target="#main">
          <img class="home_icon" src="/assets/img/category_icon.png">
          <span class="home_text">Category</span>
          </a>
        </li>
        <li class="browse">
          <a class="Browse_link" href="/access/albums/" title="Browse" data-pjax="#main" data-push="true" data-target="#main">
          <img class="home_icon" src="/assets/img/browse_icon.png">
          <span class="home_text">Browse</span>
          </a>
        </li>
        <li class="playlist">
          <a class="playlist_link" href="/playlist/featuredplaylist" title="playlist" data-pjax="#main" data-push="true" data-target="#main">
          <img class="home_icon" src="/assets/img/playlist_icon.png">
          <span class="home_text">Playlists</span>
          </a>
        </li>
        <li class="favourites">
          <a class="favourite_link" href="javascript:void(0);" title="">
          <img class="home_icon" src="/assets/img/favorites_icon.png">
          <span class="home_text">Favourites</span>
          </a>
        </li>
        <li class="help">
          <a class="help_link" href="javascript:void(0);" title="wtsongs help">
          <img class="home_icon" src="/assets/img/help_icon.png">
          <span class="home_text">Helping</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="n_box_wrapper none" id="n_box_wrapper">
      <div class="n_box_icon">
        <img src="/assets/img/add_to_playlist_icon.png">
      </div>
      <div class="n_box_song_name" id="n_box_song_name">
        <p class="boxText" id="boxText"></p>
      </div>
    </div>
<?php
  }

  function homeNav() {
?>
<div class="nav">
  <ul>
    <li><a href="/" title="overview" data-pjax="#main" data-push="true" data-target="#main">OVERVIEW</a>
    </li>
    <li><a href="/topcharts" title="top_charts" data-pjax="#main" data-push="true" data-target="#main">TOP CHARTS</a>
    </li>
    <li><a href="/newreleased/hindi" title="New Releases" data-pjax="#main" data-push="true" data-target="#main">NEW RELEASES</a>
    </li>
  </ul>
</div>
<?php
  }

  function footerBar() {
?>
<!-- ==== facebook login part html start -->
<div class="facebook_login_container">
  <div class="facebook_login">
    <p>To See Every Updates About Free Music </p>
    <a href="javascript:void(0)">
    <div class="fb_login_button ">
      <div class="socalSprit likeUsIcon"></div><p class="likeText">Like us on Facebook</p>
    </div></a>
  </div>
</div>
<!-- ==== facebook login part html start -->
<!-- ===footer part html start -->
<div class="footer_container">
  <div class="artists_link">
    <p>Artists</p>
    <ul>
      <li><a href="/artist/kumar+sanu/" title="kumar sanu" data-pjax="#main" data-push="true" data-target="#main">Kumar Sanu</a></li>
      <li><a href="/artist/arijit+singh/" title="Arijit Singh" data-pjax="#main" data-push="true" data-target="#main">Arijit Singh</a></li>
      <li><a href="/artist/honey+singh/" title="Honey Singh" data-pjax="#main" data-push="true" data-target="#main">Honey Singh</a></li>
      <li><a href="/artist/udit+narayan/" title="Udit Narayan" data-pjax="#main" data-push="true" data-target="#main">Udit Narayan</a></li>
      <li><a href="/artist/shreya+ghoshal/" title="Shreya Ghoshal" data-pjax="#main" data-push="true" data-target="#main">Shreya Ghoshal</a></li>
      <li><a href="/artist/sonu+nigam/" title="Udit Narayan" data-pjax="#main" data-push="true" data-target="#main">Sonu Nigam</a></li>
      <li><a href="/artist/atif+aslam/" title="Shreya Ghoshal" data-pjax="#main" data-push="true" data-target="#main">Atif Aslam</a></li>
      <li><a href="#" title="Browse more artist">More...</a></li>
    </ul>
  </div>
  <!--2-->
  <div class="artists_link">
    <p>Actors</p>
    <ul>
      <li><a href="/artist/salman+khan/" title="Salman Khan" data-pjax="#main" data-push="true" data-target="#main">Salman Khan</a></li>
      <li><a href="/artist/amitabh+bachchan/" title="Amitabh Bachchan" data-pjax="#main" data-push="true" data-target="#main">Amitabh Bachchan</a></li>
      <li><a href="/artist/ajay+devgan/" title="Ajay Devgan" data-pjax="#main" data-push="true" data-target="#main">Ajay Devgan</a></li>
      <li><a href="/artist/akshay+kumar/" title="Akshay Kumar" data-pjax="#main" data-push="true" data-target="#main">Akshay Kumar</a></li>
      <li><a href="/artist/shahrukh+khan/" title="Sharukh Khan" data-pjax="#main" data-push="true" data-target="#main">Shahrukh Khan</a></li>
      <li><a href="/artist/aamir+khan/" title="Aamir Khan" data-pjax="#main" data-push="true" data-target="#main">Aamir Khan</a></li>
      <li><a href="/artist/hrithik+roshan/" title="Hrithik Roshan" data-pjax="#main" data-push="true" data-target="#main">Hrithik Roshan</a></li>
      <li><a href="#" title="Browse more actors">More...</a></li>
    </ul>
  </div>
  <!--3-->
  <div class="artists_link">
    <p>Actresses</p>
    <ul>
      <li><a href="/artist/deepika+padukone/" title="Deepika Padukone" data-pjax="#main" data-push="true" data-target="#main">Deepika Padukone</a></li>
      <li><a href="/artist/kareena+kapoor/" title="Kareena Kapoor" data-pjax="#main" data-push="true" data-target="#main">Kareena Kapoor</a></li>
      <li><a href="/artist/katrina+kaif/" title="Katrina Kaif" data-pjax="#main" data-push="true" data-target="#main">Katrina Kaif</a></li>
      <li><a href="/artist/madhuri+dixit/" title="Madhuri Dixit" data-pjax="#main" data-push="true" data-target="#main">Madhuri Dixit</a></li>
      <li><a href="/artist/alia+bhatt/" title="Alia Bhatt" data-pjax="#main" data-push="true" data-target="#main">Alia Bhatt</a></li>
      <li><a href="/artist/juhi+chawala/" title="Juhi Chawala" data-pjax="#main" data-push="true" data-target="#main">Juhi Chawala</a></li>
      <li><a href="/artist/aishwary+rai/" title="Aishwarya Rai Bachchan" data-pjax="#main" data-push="true" data-target="#main">Aishwarya Rai Bachchan</a></li>
      <li><a href="#" title="Browse more actresses">More...</a></li>
    </ul>
  </div>
  <!--4-->
  <div class="artists_link">
    <p>Languages</p>
    <ul>
      <li><a href="/access/albums/hindi" title="Hindi" data-pjax="#main" data-push="true" data-target="#main">Hindi</a></li>
      <li><a href="/access/albums/english" title="English" data-pjax="#main" data-push="true" data-target="#main">English</a></li>
      <li><a href="/access/albums/punjabi" title="Punjabi" data-pjax="#main" data-push="true" data-target="#main">Punjabi</a></li>
      <li><a href="/access/albums/bhojpuri" title="Bhojpuri" data-pjax="#main" data-push="true" data-target="#main">Bhojpuri</a></li>
      <li><a href="/access/albums/maithili" title="Maithili" data-pjax="#main" data-push="true" data-target="#main">Maithili</a></li>
      <li><a href="/access/albums/marathi" title="Marathi" data-pjax="#main" data-push="true" data-target="#main">Marathi</a></li>
      <li><a href="/access/albums/telugu" title="Telugu" data-pjax="#main" data-push="true" data-target="#main">Telugu</a></li>
      <li><a href="#" title="Browse more languages">More...</a></li>
    </ul>
  </div>
</div>
<!-- ===footer part html start -->
<!-- ======footer navigation html start ======= -->
<div class="footer_nav">
  <div class="footer_nav_left">
    <div class="footer_menu">
      <ul>
        <li><a href="/about/about_us" title="About us" target="_blank">About us</a></li>
        <li><a href="javascript:void(0)" title="Partners" id="partners" data-pjax="#main" data-push="true" data-target="#main">Partners</a></li>
        <li><a href="javascript:void(0)" title="Advertise on wtsongs" id="advertise_on_wtsongs">Advertise on wtsongs</a></li>
        <li><a href="javascript:void(0)" title="Terms of use" onclick="pp_page('tou')">Terms of use</a></li>
        <li><a href="javascript:void(0)" title="Privacy policy" onclick="pp_page('pp');">Privacy policy</a></li>
        <li><a href="javascript:void(0)" title="Feedback" id="feedback">Feedback</a></li>
        <li><a href="javascript:void(0)" title="Report on issue" id="reportIssue">Report on issue</a></li>
        <li><a href="javascript:void(0)" title="FAQ" id="faq">FAQ</a></li>
      </ul>
    </div>
    <p>Copyright © 2015, <a href="www.wtsongs.com" data-pjax="#main" data-push="true" data-target="#main">wtsongs.com</a></p>
  </div>
  <div class="footer_nav_right">
         <p>follow us on :</p>
    <a href="http://www.facebook.com/wtsongs2015" title="wtsongs on facebook" target="_blank">
      <div class="fb_icon socalSprit"></div>
    </a>
    <a href="http://www.twitter.com/wtsongs" title="wtsongs twitter">
      <div class="tw_icon socalSprit" target="_blank"></div>
    </a>
    <a href="http://google.com/+wtsongs2015" title="wtsongs on google+" target="_blank">
      <div class="g_icon socalSprit"></div>
    </a>
    <div class="in_icon socalSprit">
       <a href="javascript:void(0);" title="wtsongs on linkedin"></a>
    </div>
  </div>
</div>
<div id="static_privacy_policy"></div>
<!-- For facebook libraries -->
<div id="fb-root"></div>
<!-- ======footer navigation html end ======= -->
<?php
    include root_dir . '/include/controller/common/search.php';
    $mapped_data = $this->user_map();
    if( $mapped_data !== false ) {
      echo '<span id="user_map" style="display:none">' . json_encode($mapped_data) . '</span>';
    }
    $this->feedbackForm();
  }

  function loginForm() {
?>
<!-- Login Box -->
<div id="loginBox"></div>
<!-- create playlist box -->
<div id="createplaylist"><div class="test none"></div></div>
<!-- Share Popup -->
<div id="sharecontent"><div class="test none"></div></div>
<!-- queue box -->
<div class="queueBlock none overlay_background">
  <div id="queueBoxContainer">
    <div class="qeBox">
      <div class="qeTopButton">
        <a id="queueSave" class="qeBtn btn-small green">Save</a>
        <a id="queueClear" class="qeBtn btn-small green">Clear</a>
        <a id="queueMore" class="qeBtn btn-small green">More</a>
      </div>
      <div class="closeQe closeButton" onclick="hideStaticBox()" style="float:right; top:12px; position:absolute; right:20px; cursor:pointer; width:20px; height:20px;"></div>
      <div class="qeBody customscroll">
        <div id="queueBox"></div>
      </div>
    </div>
  </div>
</div>

<?php
  }

  function rightSideBar() {
?>
<div class="right_side_bar" id="sidebar"><img src="http://img.wtsongs.com/images/static/right_side.jpg"></div>
<a href="http://www.beyondsecurity.com/vulnerability-scanner-verification/www.wtsongs.com"><img src="https://seal.beyondsecurity.com/verification-images/www.wtsongs.com/vulnerability-scanner-2.gif" alt="Website Security Test" border="0" /></a>

<?php
  }

  public function pagination($total_data, $ipp, $curPage, $curUrl) {

  }

  function popularNav() {
    echo '
<div class="browse_page_nav1">
  <ul>
    <li><a href="/mostpopular/" title="song" data-push="true" data-target="#main">Song</a></li>
    <li><a href="/access/albums/hindi" title="albums" data-push="true" data-target="#main">Albums</a></li>
    <li><a href="/access/genres/bollywood" title="genre" data-push="true" data-target="#main">Genre</a></li>
    <li><a href="/access/artists/hindi" title="artist" data-push="true" data-target="#main">Artist</a></li>
    <li><a href="/topcharts" title="top_charts" data-pjax="#main" data-push="true" data-target="#main">Top Charts</a></li>
    <li><a href="/hello.php" title="pjax" data-pjax="#main" data-push="true" data-target="#main">pjax</a></li>
  </ul>
</div>';
  }

  function langNav($link, $type) {
    if( $type == "lang" ):
      $Arr = array( 'HINDI', 'ENGLISH', 'BHOJPURI', 'PUNJABI', 'MARATHI', 'BENGALI', 'MAITHILI', 'MALAYALAM', 'TELUGU', 'TAMIL', 'GUJARATI' );
    elseif( $type == "genres" ):
      $Arr = array( 'BOLLYWOOD', 'REMIX', 'POP', 'COMPILATION', 'GHAZAL', 'NON-STOP', 'SUFI', 'INSTRUMENTAL', 'BHANGRA', 'BEWAFA', 'PAKISTANI', 'MARATHI' );
    endif;
?>
<div class="browse_page_nav2">
  <ul>
  <?php
  foreach( $Arr as $key => $value ) {
    echo '<li><a href="' . $link . strtolower($value) . '" title="' . strtolower($value) . '" class="' . strtolower($value) . '" data-pjax="#main" data-push="true" data-target="#main">' . $value . '</a></li>';
  }
  ?>
  </ul>
</div>

<?php
  }

  function footerPlayer() {
?>

<div class="fixed_player_wrapper">
  <div class="fixed_player_wrapper_ad">
    <div class="fixed_player_wrapper_ad_inner playerImg"></div>
  </div>
  <ul class="fixed_player_button">
    <a href="javascript:void(0)" title="prev_songs"><li class="fixed_player_prev_button backWard"></li></a>
    <a href="javascript:void(0)" title="stop_songs"><li class="fixed_player_stop_button stopControl"></li></a>
    <a href="javascript:void(0)" title="next_songs"><li class="fixed_player_next_button foreWard"></li></a>
  </ul>
  <div class="cover"></div>
  <div class="control">
    <div class="meta">
    <div class="player_songs_details">
      <p class="player_track_name"><a href="javascript:void(0)" class="dotes"></a></p>
      <span class="player_album_name dotes"><a href="javascript:void(0)"></a></span>
      </div>
      <a href="javascript:void(0);" title="download"><div class="player_album_more"></div></a>
      <a href="javascript:void(0);" title="share"><div class="player_album_more"></div></a>
      <a href="javascript:void(0);" title="more">
        <div class="player_album_more">
          <div class="bitrate_drop seogiUI">
            <ol>
              <li class="bitrate_note">
                MUSIC QUALITY
              </li>
              <li class="bitrate_text">
                <a onclick="Player.setBitrate(64);">Good <em class="small">64 kbps</em><span id="bitrate-64" class="current-bitrate"></span></a>
              </li>
              <li class="bitrate_text">
                <a onclick="Player.setBitrate(128);">Best <em class="small">128 kbps</em><span class="" id="bitrate-128"></span></a>
              </li>
            </ol>
          </div>
        </div>
      </a>
      <div class="like_us_also">Queue</div>
    </div>
    <div class="player_album_progreser">
    <button style="opacity: 0.3;" class="repeat" title="repeat current song"></button>
    <p class="elipsed_time">0:00</p>
   <div class="progress_gutter"><div class="pro"></div></div>
   <p class="track_time">0:00</p>
   <div class="volume_wrapper">
    <div class="volume" title="set volume">
    </div>
    </div>
    </div>
  </div>
</div>

<?php
  }

  function top_banner() {
    echo '<div class="top_banner"><center><img src="http://img.wtsongs.com/images/static/top_banner.jpg" /></center></div>';
  }

  function fpNav() {

?>

<div class="playlist_page_nav">
  <ul>
    <li>
      <a href="/playlist/featuredplaylist" title="featured_playlists" class="featuredplaylist" data-pjax="#main" data-push="true" data-target="#main">FEATURED PLAYLISTS</a>
    </li>
    <li>
      <a href="/playlist/usersplaylist" title="user_playlists" class="usersplaylist" data-pjax="#main" data-push="true" data-target="#main">USER PLAYLISTS</a>
    </li>
  </ul>
</div>

<?php

  }

  function carousel() {

?>

<div class="new_releases">
  <div class="corousal_heading">
    <a  class="heading" href="/access/albums/" title="new_releases" data-pjax="#main">You May Also Like</a>
  </div>
  <div class="new_releases_corousal">
    <div class="new_releases_corousal_inner imageWrapper">
    <?php
    if( $this->carouselType == "album" ) {
      $this->cr_albumSql();
    }
    list( $crAlbumData ) = $this->cr_albumSql();
    ?>
    <?php foreach( $crAlbumData['album_title'] as $key => $value ) { ?>
    <a href="/album/<?php echo $crAlbumData['album_url'][$key]; ?>" data-pjax="#main" data-push="true" data-target="#main">
      <div class="latest">
        <div class="player">
          <img src="/assets/img/player_icon2.png" alt="player_image"/>
        </div>
        <div class="latest_img">
          <img src="<?php echo $crAlbumData['album_image'][$key]; ?>" alt="<?php echo $crAlbumData['album_title'][$key]; ?>" />
        </div>
        <div class="movies_details">
          <div class="movie_name">
            <a href="/album/<?php echo $crAlbumData['album_url'][$key]; ?>" data-pjax="#main" data-push="true" data-target="#main" title="<?php echo $crAlbumData['album_with_year'][$key]; ?>"><?php echo $crAlbumData['album_title'][$key]; ?></a>
          </div>
          <div class="artist"><a href="/artist/<?php echo $crAlbumData['artist_url'][$key]; ?>/" data-pjax="#main" data-push="true" data-target="#main" class="singer" title="<?php echo $crAlbumData['album_artist'][$key]; ?>"><?php echo $crAlbumData['album_artist'][$key]; ?></a>
          </div>
        </div>
      </div>
    </a>
      <?php } ?> 
    </div>
    <div class="left_button controlSlideLeft">
      <div class="prev_button"><img src="/assets/img/prev_arrow.png"></div>
    </div>
    <div class="right_button controlSlideRight">
      <div class="next_button"><img src="/assets/img/next_arrow.png"></div>
    </div>
  </div>
</div>

<?php

  }

  function feedbackForm() {
?>

<div class="feedbackFromBlock none overlay_background">
<div class="feed_wrapper">
  <!-- header part-->
  <div class="feed_head">
    <h3>Feedback</h3> 
  </div>
  <div class="feed_cancel">
    <img src="/assets/img/cancel.png">
  </div>
      <!-- header part-->
  <div class="feed_middle">
  <form name="feedback" onsubmit="return submitFeedback()">
    <input type="text" name="name" placeholder="Your name" autocomplete="off" maxlength="30">
    <input type="text" name="email" placeholder="Your email" autocomplete="off" maxlength="50">
    <select name="selection_cat" class="selectionCat">
      <option value="">Feedback Category</option>
      <option value="music">Music</option>
      <option value="design">Design</option>
      <option value="user_experience">User experience</option>
      <option value="audio_quality">Audio Quality</option>
      <option value="audio_downloading">Audio Downloading</option>
      <option value="Report_an_issue">Report an issue</option>
    </select>
    <textarea placeholder="Explore your feedback matter...." name="matter" autocomplete="off" maxlenght="300"></textarea>
  <!--footer part  html start -->
  <div class="feed_recaptcha"></div>
  <input type="submit" value="submit">
  </form>
  </div>
</div>
</div>

<?php
  }

  function infinityScroll($data) {

?>

<script type="text/javascript">
  $(document).ready(function() {
    // Infinite Ajax Scroll configuration
    jQuery.ias({
      container : '<?php echo $data[0]; ?>', // main container where data goes to append
      item: '<?php echo $data[1]; ?>', // single items
      pagination: '<?php echo $data[2]; ?>', // page navigation
      next: '<?php echo $data[3]; ?>', // next page selector
      loader: '<img class="infinite_loader" src="/assets/img/modal-loader.gif"/>', // loading gif
      triggerPageThreshold: <?php echo $data[4]; ?>, // show load more if scroll more than this
      history : false
    });
  });
</script>

<?php

  }

  //update album or playlists hits to db
  function update_a_or_pl_hits($data, $type) {
    if( $type == "album" || $type == "playlist" || $type == "artist" || $type == "song" || $type == "download_song_by_user" ) {
      if( $type == "album" ) {
        $qd = array('from' => 'wt_albums', 'select' => 'album_hits', 'where' => 'album_id' );
      } elseif( $type == "playlist" ) {
        $qd = array('from' => 'wt_playlists', 'select' => 'total_hits', 'where' => 'playlist_id');
      } elseif( $type == "artist" ) {
        $qd = array('from' => 'wt_artists', 'select' => 'artist_hits', 'where' => 'artist_id');
      } elseif( $type == "song" ) {
        $qd = array('from' => 'wt_tracks', 'select' => 'download_hits', 'where' => 'track_id' );
      } elseif(  $type == "download_song_by_user" ) {
        $qd = array('from' => 'wt_usermeta', 'select' => 'object_id', 'where' => 'term_id=45 AND user_id' );
      }
      //get total hits
      $total_hits = mysqli_query( $GLOBALS['link'], "SELECT " . $qd['select'] . " as total_hits FROM " . $qd['from'] . " WHERE " . $qd['where'] . "='" . $data . "'" );
      if( mysqli_num_rows( $total_hits ) == 1 ) {
        $total_hits = mysqli_fetch_array( $total_hits, MYSQLI_ASSOC );
        $total_hits = $total_hits['total_hits'];
        //increse hits
        $total_hits = $total_hits + 1;
        //update total_hits
        $update_hits = mysqli_query( $GLOBALS['link'], "UPDATE " . $qd['from'] . " SET " . $qd['select'] . "='" . $total_hits . "' WHERE " . $qd['where'] . "='" . $data . "'" );
        if (!$update_hits) {
          die('Invalid query: ' . mysqli_error());
        } else return true;
      } else $error = "Hits does't found";
    } else $error = "Type does't set";

    if( isset($error) ) {
      return $error;
    }
  }

  //fb comments
  function fb_comment() {
?>

<div class="comment-box" id="comment-box">
  <div id="fb-root"></div>
    <div class="comment-text text seogiUI">
      comment
      <a class="show-hide-comment text seogiUI" data-value="comment-toggle"></a>
    </div>
    <div class="comment-container none">
      <div class="fb-comments" data-href="<?php echo page_url; ?>" data-width="100%" data-numposts="10" data-colorscheme="dark"></div>
    </div>
</div>

<?php
  }

  function user_map() {
    if( defined('logged_in') && logged_in === true ) {
      //get user_id
      $user_data = mysqli_query( $GLOBALS['link'], "SELECT u.unique_user_name, u.firstname, u.fb_id, u.pass_token, (SELECT object_id FROM wt_usermeta as um WHERE um.user_id='" . user_id . "' AND um.term_id='29' ) as user_art FROM wt_users as u WHERE u.id='" . user_id . "'" );
      if( mysqli_num_rows($user_data) > 0 ) {

        $user_data = mysqli_fetch_assoc($user_data);

        $mapped['user']['unique_user_name'] = $user_data['unique_user_name'];
        $mapped['user']['firstname'] = $user_data['firstname'];
        if( strlen($user_data['fb_id']) > 5 ) $mapped['user']['fb_status'] = 'Y'; else $mapped['user']['fb_status'] = 'N';
        if( $user_data['pass_token'] == 'active' ) $mapped['user']['user_status'] = "Y"; else $mapped['user']['user_status'] = 'N';
        if( is_null($user_data['user_art']) ) $mapped['user']['user_art'] = "/assets/img/default_user.jpg"; else $mapped['user']['user_art'] = "http://img.wtsongs.com/images/uploades/medium/" . user_id . "/" . $user_data['user_art'] . ".jpg";

        return $mapped;
      } else return false;
    } else return false;
  }

  function bottomScripts() {

    include $GLOBALS['rootDir'] . '/include/main-content/content_fun/bootom_script.php';

  }
  
}


?>