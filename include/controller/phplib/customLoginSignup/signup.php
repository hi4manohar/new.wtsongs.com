<?php
$rootDir =  $_SERVER['DOCUMENT_ROOT'];
require_once $rootDir . '/include/controller/class/class.top.php';
require_once $rootDir . '/include/controller/db/DBConfig.php';
require_once $rootDir . '/include/controller/common/common_class.php';
$salt = "4d5kd9k39dkf7i0q84p9ex20c7w0c3ui";
$common = new commonClass();
$top = new top_of_page();

//temporary
function sendConfirmail( $emailData ) {
  $to = $emailData[0];
  $subject = $emailData[1];
  $from = $emailData[2];
  $body = $emailData[3];
  $headers = "From: " . strip_tags($from) . "\r\n";
  $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
  mail($to, $subject, $body, $headers);
  return true;
}

//new send mail function
function sendmail( $emailData ) {
  if( isset($emailData['from']) && !empty($emailData['from']) ) {
    $to = $emailData['to'];
    $subject = $emailData['subject'];
    $from = $emailData['from'];
    $body = $emailData['body'];
    $headers = "From: " . strip_tags($from) . "\r\n";
    $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    if( mail($to, $subject, $body, $headers) ) {
      return true;
    } else return false;
  } else return false;
}

//signup functionality
if( isset($_POST['user_email']) && isset($_POST['user_name']) && isset($_POST['user_pass']) && isset($_POST['user_confirm_pass']) ) {
  include $rootDir . '/include/controller/phplib/customLoginSignup/signup_functionality.php';
}

//login functionality
elseif(isset($_POST['user_login'])) {
  include $rootDir . "/include/controller/phplib/customLoginSignup/login_functionality.php";
}

//forgot password functionality
elseif( isset($_POST['status']) == "forgotpass" ) {
  include $rootDir . "/include/controller/phplib/customLoginSignup/forgot_pass_functionality.php";
}

//reset password functionality
elseif( isset( $_POST['resetpass'] ) == "resetpass" ) {
  include $rootDir . "/include/controller/phplib/customLoginSignup/reset_pass.php";
} else {
  $error[] = "Every field is required";
}

if( isset( $_GET['checkstatus'] ) == "login" ) {
  if(isset( $_SESSION['user_email'] ) && isset( $_SESSION['user_id'] ) ) {
    echo "true";
  } else {
    echo "false";
  }
}

//feedback submission
if( isset($_POST['type']) == "fdsub" ) {
  include $rootDir . "/include/controller/phplib/customLoginSignup/feedback_submission.php";
}

//email updation of fb registered user
if( isset($_POST['tag']) == "fb_emailUpdates" && isset($_POST['email']) ) {
  include $rootDir . "/include/controller/phplib/customLoginSignup/fb_email_updatation.php";
}

//user_settings updation
if( isset($_POST['do']) ) {
  include $rootDir . "/include/controller/phplib/customLoginSignup/user_settings.php";
}

?>