<?php  
  if( isset($_POST['login_email']) && isset($_POST['login_password']) ) {
    $login_email = mysqli_real_escape_string( $link, $_POST['login_email'] );
    $login_pass = mysqli_real_escape_string( $link, $_POST['login_password'] );

    $query = "select * from wt_users where email='" . $login_email . "' AND password='" . md5($salt.$login_pass) . "'";

    $result = mysqli_query( $link, $query );
    if(mysqli_num_rows($result) > 0) {
      while( $userRow = mysqli_fetch_assoc($result) ) {
        $user_id = $userRow['id'];
        $user_name = $userRow['firstname'];
      }
      $_SESSION['user_id'] = $user_id;
      $_SESSION['user_email']=$login_email;
      $_SESSION['user_name']=$user_name;
      $top->set_session_cookie( $login_email );
      echo "success";
    } else {
      echo "error";
    }
  }
?>