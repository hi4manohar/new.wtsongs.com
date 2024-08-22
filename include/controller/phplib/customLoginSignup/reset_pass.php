<?php
  if( isset($_POST['pass']) && isset($_POST['confir_pass']) && isset($_POST['token']) ) {
    $pass = mysqli_real_escape_string( $link, $_POST['pass'] );
    $confirm_pass = mysqli_real_escape_string( $link, $_POST['confir_pass'] );
    $token = $_POST['token'];

    if(strlen($pass) < 5){
      $error[] = 'password should be greater than 5 character.';
    }
    if($pass !== $confirm_pass){
      $error[] = 'passwords do not match.';
    }
    if( empty($error) ) {
      $getTokenData = mysqli_query( $link, "SELECT * FROM wt_users WHERE pass_token='" . $token . "'" );
      if( mysqli_num_rows($getTokenData) == 1 ) {
        mysqli_query($link, "UPDATE wt_users SET password='" . md5($salt . $pass) . "',pass_token='active' WHERE pass_token='" . $token . "'");
        while( $userRows = mysqli_fetch_assoc($getTokenData) ) {
          $_SESSION['user_id'] = $userRows['id'];
          $_SESSION['user_email']=$userRows['email'];
          $_SESSION['user_name']=$userRows['firstname'];
        }
        echo "success";
      } else {
        $error[] = "token missmatch!!";
      }
      
    }
    else {
      foreach ($error as $key => $value) {
        echo $error[$key] . "\n";
      }
    }
  }
?>