<?php

class loggedoutContent {

  public $forgotToken;

  public function topHeader() {
    echo '<div class="top_header">';
    $this->topHeaderLogo();
    echo '<div id="l_d_wrapper">';
    $this->topHeaderLogin();
    echo '</div>';
    echo '</div>';
  }

  public function resetPassForm($token) {
    $this->forgotToken = $token;
    $checkToken = $this->checkToken();
    if( $checkToken == true ) {
      $this->resetForm();
    } else {
      $this->wrongToken();
    }
    
  }

  function checkToken() {
    $tokenSql = "SELECT id FROM wt_users WHERE pass_token='" . $this->forgotToken . "'";
    $tokenResult = mysqli_query( $GLOBALS['link'], $tokenSql );
    if( mysqli_num_rows( $tokenResult ) > 0 ) {
      return true;
    } else return false;
  }

  function wrongToken() {
    echo '<script>sweetAlert("Oops...", "your token is incorrect!", "error");</script>';
  }

  function topHeaderLogo() {
    include root_dir . "/include/main-content/content_fun/logo_search_box.php";
  }

  function topHeaderLogin() {
    echo '
      <div class="loginBox">
        <ul>
          <li class="login_icon_container" onclick="showLoginBox()">
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

  function resetForm() {

?>

<div class="reset_password_container">
  <h4>Enter Your New Password</h4>
  <form name="reset_password_form" id="reset_password_form" onsubmit="return resetPass('<?php echo $this->forgotToken; ?>')">
    <input type="password" name="new_password" placeholder="enter your new password">
    <input type="password" name="conform_password" placeholder="conform your password">
    </br>
    <input type="submit" value="Submit">
    <input type="button" value="Cancel" onclick="cancelResetPass()">
  </form>
</div>

<?php

  }
}

?>