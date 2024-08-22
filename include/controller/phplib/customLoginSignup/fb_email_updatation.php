<?php

  $email = $_POST['email'];

  $emailValidation = $common->emailValidation( $email );

  if( $emailValidation === true ) {
    $emailResult = $common->execute_query( "SELECT * FROM wt_users WHERE email='$email'" );
    if( mysqli_num_rows($emailResult) > 0 ) {
      echo "Your email is already exist, please use another email";
    } else {
      $query = $common->execute_query( "UPDATE wt_users SET email='" . $email . "' WHERE id='$top->user_id'" );
      if( $query !== false ) {

        //update unique user_name
        $unique_user_name = $common->execute_query("SELECT unique_user_name FROM wt_users WHERE id='" . $top->user_id . "'");
        $unique_user_name = mysqli_fetch_assoc( $unique_user_name );
        $unique_user_name = $unique_user_name['unique_user_name'];
        if( is_numeric($unique_user_name) ) {
          $unique_user_name_arr = explode('@', $email);
          $unique_user_name = $unique_user_name_arr[0];
          $update_unique_name_result = $common->execute_query( "UPDATE wt_users SET unique_user_name='" . $unique_user_name . "' WHERE id='$top->user_id'" );
        }

        echo "success";
        //update session
        $_SESSION['user_email'] = $email;
      } else echo "Some technical problem occured in updating you email address";
    }
  } elseif( $emailValidation == "invalidEmail" ) {
    echo "Your email is invalid, please check your email";
  } else {
    echo "we are not accepting these domains of email, please use another domain of email";
  }

?>