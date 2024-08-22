<?php

  if( $_POST['do'] == "updateuser" ) {
    if( isset( $_POST['update'] ) && $_POST['update'] == "user_detail" && $_POST['fname'] && $_POST['lname'] && $_POST['user_email'] ) {

      $user['fname'] = $common->testitle($_POST['fname']);
      $user['lname'] = $common->testitle($_POST['lname']);
      $user['user_email'] = $common->testitle($_POST['user_email']);
      $user['name'] = $user['fname'] . " " . $user['lname'];
      $parts = explode(" ", $user['name'], 2);
      $user['lname'] = $parts[1];
      $user['fname'] = $parts[0];

      $v_result = $common->emailValidation($user['user_email']);
      if( $v_result === true && strlen($user['fname']) > 2 && strlen($user['lname']) > 2 && strlen($user['user_email']) > 5 ) {

        if( preg_match("/^[a-zA-Z ]*$/",$user['name']) ):

        if( $common->query_execute( "UPDATE wt_users SET name='" . $user['name'] . "', firstname='" . $user['fname'] . "', lastname='" . $user['lname'] . "', email='" . $user['user_email'] . "' WHERE id=$top->user_id" ) ) {

          //update unique user_name
          $unique_user_name = $common->execute_query("SELECT unique_user_name FROM wt_users WHERE id='" . $top->user_id . "'");
          $unique_user_name = mysqli_fetch_assoc( $unique_user_name );
          $unique_user_name = $unique_user_name['unique_user_name'];
          if( is_numeric($unique_user_name) ) {
            $unique_user_name_arr = explode('@', $user['user_email']);
            $unique_user_name = $unique_user_name_arr[0];
            $update_unique_name_result = $common->execute_query( "UPDATE wt_users SET unique_user_name='" . $unique_user_name . "' WHERE id='$top->user_id'" );
          }

          //update session
          $_SESSION['user_name'] = $user['fname'];
          $_SESSION['user_email'] = $user['user_email'];

          echo "success";
        } else {
          echo "Some technical problem occured";
        }
        else:
          echo "First and Lastname should be only alphanumeric";
        endif;

      } else {
        if( $v_result == "invalidEmail" ) {
          echo "Invalid Email";
        } elseif( $v_result == "invalideDomain" ) {
          echo "We are not accepting these domain of email address \n please enter another email address!";
        }
      }
    } else {
      echo "Updation detail not defined";
    }
  } elseif( isset($_POST['update']) && $_POST['update'] == "user_config" ) {
    foreach ($_POST as $key => $value) {
      if( $key == "update" || $key == "do" ) {
      } else {
        $check_term_exist = $common->execute_query( "SELECT term_id FROM wt_terms WHERE name='" . $key . "'" );
        if( mysqli_num_rows( $check_term_exist ) == 1 ) {
          $term_id_arr = mysqli_fetch_assoc( $check_term_exist );

          //check if config exist in user_meta
          $config_exist = $common->execute_query( "SELECT * FROM wt_usermeta WHERE user_id='" . $top->user_id . "' AND term_id='" . $term_id_arr['term_id'] . "'" );
          if( mysqli_num_rows( $config_exist ) == 1 ) {
            //update config
            if( $common->query_execute("UPDATE wt_usermeta SET `term_id`='" . $term_id_arr['term_id'] . "', `object_id`='" . $value . "', `is_fav`='0' WHERE `user_id`='" . $top->user_id . "' AND term_id='" . $term_id_arr['term_id'] . "'" ) ) {
              echo "success";
            }
          } elseif( mysqli_num_rows( $config_exist ) < 1 ) {
            //insert config
            if( $common->query_execute("INSERT INTO wt_usermeta (`user_id`, `term_id`, `object_id`, `is_fav`) VALUES('" . $top->user_id . "', '" . $term_id_arr['term_id'] . "', '" . $value . "', '0')") ) {
              echo "success";
            }

          }
        } else echo "Check your configuration settings";
      }
    }
    
  } else {
    echo "action is not defined";
  }

?>