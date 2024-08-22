<?php

class loggedinContent {
  public function topHeader() {
    echo '<div class="top_header">';
    $this->topHeaderLogo();
    echo '<div id="l_d_wrapper">';
    $this->topHeaderLogin();
    echo '</div>';
    echo '</div>';
  }

  function topHeaderLogo() {
    include root_dir . "/include/main-content/content_fun/logo_search_box.php";
  }

  function topHeaderLogin() {
    require_once root_dir . "/include/controller/common/common_class.php";
    $common_obj = new commonClass();

?>

<div class="l_d_wrapper">
  <div class="l_d_users">
    <a href="javascript:void(0)" title="">
      <div class="l_d_icon_containner">
        <?php
        $fb_id = $common_obj->check_fb_user(user_id);
        if( $fb_id !== false )
          echo "<img src=\"https://graph.facebook.com/$fb_id/picture?type=small\">";
        else echo "<img src=\"/assets/img/l_d_users_icon.png\">";
        ?>
      </div>
      <div class="l_d_text_containner">
        <center><p><?php echo $_SESSION['user_name']; ?></p></center>
      </div>
    </a>
  </div>
  <div class="l_d_notification">
    <a href="javascript:void(0)" title="notification">
      <div class="l_d_notification_containner">
        <img src="/assets/img/l_d_notification_icon.png">
      </div>
      <div class="l_d_notification_text">
        <center><p>notification</p></center>
      </div>
    </a>
  </div>
</div>

  <!-- slider part html start -->
<ul class="l_d_slider_wrapper none">
  <li class="my_home">
    <a href="/myhome/" data-pjax="#main" data-push="true" data-target="#main">
      <img src="/assets/img/my_home.png" class="my_home_icon">my home
    </a>
  </li>
  <li class="my_home">
    <a href="#">
      <img src="/assets/img/wt_rwards.png" class="my_home_icon">wt rewards
    </a>
  </li>
  <li class="my_home">
    <a href="/myhome/mysettings" data-pjax="#main" data-push="true" data-target="#main">
      <img src="/assets/img/song_setting.png" class="my_home_icon">settings
    </a>
  </li>
  <li class="my_home">
    <a href="/userlogout">
      <img src="/assets/img/my_logout.png" class="my_home_icon">logout
    </a>
  </li>
</ul>
<ul class="l_d_not_wrapper none customscroll">
  <li class="my_home ldtext">
    <a href="javascript:void(0)">Hello, Welcome to the wtsongs.com</a>
  </li>
</ul>
<!-- notification part html start -->
<div class="notification_content_wrapper">
  <div class="notification_content_inner">
    <p>no notification</p>
  </div>
</div>


<?php

  }

}

class createplaylistpopup {

  public $user_id;

  public function createplaylist() {
    if( isset($GLOBALS['user_id']) && !empty($GLOBALS['user_id']) ) {
      $this->user_id = $GLOBALS['user_id'];
      $this->listpop();
    }
    
  }

  public function playlistItem() {
    $pl_sql = "SELECT playlist_id, playlist_title FROM wt_playlists WHERE user_id='$this->user_id' LIMIT 50";
    $plResult = mysqli_query( $GLOBALS['link'], $pl_sql );

    if( mysqli_num_rows($plResult) > 0 ) {
      while ( $plRow = mysqli_fetch_assoc($plResult) ) {
        $pl['playlist_title'][] = $plRow['playlist_title'];
        $pl['playlist_id'][] = $plRow['playlist_id'];
      }
      return $pl;
    } else return false;
  }

  function listpop() {

?>

<div class="create_playlist_container overlap_popup">
  <div class="create_playlist_top_part">
    <h1>Create Playlist</h1>
    <div class="create_playlist_cancel_button" onclick="hideplaylistpop()"><img src="/assets/img/cancel.png"></div>
  </div>
  <ul class="create_playlist_content customscroll">
  <?php
  $plData = $this->playlistItem();
  if($plData) {
    foreach( $plData['playlist_id'] as $key => $value ) {
  ?>
    <li class="user_playlist_name">
      <img src="/assets/img/user_playlist_icon.png" alt="user_playlist_icon">
        <a class="add-to-track" href="javascript:void(0)" title="<?php echo $plData['playlist_title'][$key]; ?>"><?php echo $plData['playlist_title'][$key]; ?></a>
    </li>
  <?php } } ?>
  </ul>
  <div class="create_playlist_footer">
    <form onsubmit="return cpbypopup();">
      <input type="text" id="create_playlist" placeholder="Playlist Name" autocomplete="off" maxlength="70" /><br>
      <input type="checkbox" id="ispublic" value="1" /><label class="playlist_public">Public</label>
      <input type="submit" value="Create Playlist" />
    </form>
  </div>
</div>

<?php

  }

}

?>