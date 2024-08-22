<?php

//Encryption class extends
class_exists("Encryption") ? "" : require_once("class.encrypt_decrypt.php");

class top_of_page extends Encryption {

  function trimData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function session_status() {
    if (session_status() == PHP_SESSION_ACTIVE) {
      return true;
    } else return false;
  }

  public function __construct() {
    session_start();
    $this->full_page_constants();
    if(isset( $_SESSION['user_email'] ) && isset( $_SESSION['user_id'] ) ) {
      $this->session_constants();
    } else {
      /*
      @ function find for login_cokie is set or not
      @ if not set then logged_in status will be default
      @ otherwise logged_in status will be set
      */
      $this->check_logged_in_cookie();
      $this->set_logged_in_const();
      $this->user_id = 1;
    }
  }

  //usable constant for whole page
  function full_page_constants() {
    defined('root_dir') ? "" : define('root_dir', $_SERVER['DOCUMENT_ROOT']);
    defined('page_url') ? "" : define('page_url', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    defined('baseUrl')  ? "" : define('baseUrl', "http://$_SERVER[HTTP_HOST]");
  }

  function session_constants() {
    $this->user_id = $_SESSION['user_id'];
    $this->user_email = $_SESSION['user_email'];
    $this->user_name = $_SESSION['user_name'];
    $this->set_logged_in_const( true );
    defined('user_name') ? "" : define('user_name', $this->user_name);
    defined('user_id')   ? "" : define('user_id', $this->user_id);
    defined('user_email')? "" : define('user_email', $this->user_email);
  }

  function check_script_enable() {
    echo '<noscript><meta http-equiv="refresh" content="0; URL=/badbrowser.php"></noscript>
    ';
  }

  // @param for logged_in session_data
  function set_session_data( array $session_data ) {
    $_SESSION['user_id']    = $session_data[0];
    $_SESSION['user_email'] = $session_data[1];
    $_SESSION['user_name']  = $session_data[2];
  }

  //used for set constant logged_in status
  function set_logged_in_const( $status = false ) {
    defined('logged_in') ? "" : define('logged_in', $status);
  }

  function check_logged_in_cookie() {
    if( isset($_COOKIE['xyz']) ) {
      $cookie_decoded_val = $this->decode( $_COOKIE['xyz'] );
      if( $this->verify_cookie( $cookie_decoded_val ) ) {
        /*
        @cookie verified set session credentials
        @get session_data
        */
        $row = $this->execute_query( "SELECT * FROM wt_users as u WHERE u.email='$cookie_decoded_val'" );
        if(mysqli_num_rows($row) > 0) {
          while( $userRow = mysqli_fetch_assoc($row) ) {
            $user_id = $userRow['id'];
            $user_name = $userRow['firstname'];
          }
          $this->set_session_data( array($user_id, $cookie_decoded_val, $user_name) );
          $this->session_constants();
        }
      } else {
        //cookie not verified set logged_in false
      }
    } elseif( isset($_SESSION['user_email']) && isset($_SESSION['user_id']) ) {
      //set cookie if session is set, but cookie is not
      $this->set_session_cookie( $_SESSION['user_email'] );
    }
  }

  function set_session_cookie( $email ) {
    $xyz_val = $this->encode( $email );
    setcookie('xyz', $xyz_val, time() + (86400 * 3), "/");
  }

  function verify_cookie( $cookie_val ) {
    if( $this->email_exist($cookie_val) ) {
      return true;
    } else return false;
  }
}

function redirect($url) {
  if(!headers_sent()) {
    //If headers not sent yet... then do php redirect
    header('Location: '.$url);
    exit;
  } else {
    //If headers are sent... do javascript redirect... if javascript disabled, do html redirect.
    echo '<script type="text/javascript">';
    echo 'window.location.href="'.$url.'";';
    echo '</script>';
    echo '<noscript>';
    echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
    echo '</noscript>';
    exit;
  }
}


function goto_errorpage() {
  redirect("/error_page");
}

function scriptAlert($alertText) {
  echo "<script>alert('$alertText');</script>";
}

function pagination($url) {

?>

<div class="pagination_container">
  <center>
    <div class="pagination_container_inner"></div>
  </center>
</div>
<div class="innav">
  <a href='<?php echo $url; ?>'></a>
</div>

<?php

}

function page_request_type() {
  if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) ) {
    return true;
  } else {
    return false;
  }
}

class top_css_file {

  function main_css() {
    echo '
    <link rel="stylesheet" type="text/css" href="/assets/css/web_new.css">
    ';
  }

  function process_css( array $css_files ) {
    foreach ($css_files as $key => $value) {
      echo "
    <link rel=\"stylesheet\" type=\"text/css\" href=\"$value\">";
    }
  }
}

?>