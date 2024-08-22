<?php

class user_config {

  private $common_class;
  private $user;

  function display_stuff($user, $common_class) {

    //make it memeber of this class
    $this->common_class = $common_class;
    $this->user = $user;

    $user = $common_class->testitle($user);
    //user_details
    $user_result = $common_class->execute_query( "SELECT id, unique_user_name, email, name, firstname, lastname FROM wt_users as u WHERE u.unique_user_name='$user'" );

    if( mysqli_num_rows($user_result) == 1 ) {
      $user_data = mysqli_fetch_assoc($user_result);
      //check if user logged in and he is going to access his own profile
      if( logged_in ) {
        if( $user_data['id'] == user_id ) {
          redirect("/myhome/");
        } else $this->user_access_config( $user_data );
      } else $this->user_access_config( $user_data );
    } else goto_errorpage();
  }

  function user_access_config($user_data) {
    global $user_data_show;
    $user_conf_result = $this->common_class->execute_query( "SELECT object_id FROM wt_usermeta WHERE user_id='" . $user_data['id'] . "' AND term_id BETWEEN 30 AND 34" );
    if( mysqli_num_rows($user_conf_result) == 5 ) {
      //user config details
      while( $user_show_conf = mysqli_fetch_assoc($user_conf_result) ) {
        $user_data_index[] = $user_show_conf['object_id'];
      } $user_data_show = array( 'p_pic' => $user_data_index[0], 'f_song' => $user_data_index[1], 'email_pub' => $user_data_index[2], 'fav_album' => $user_data_index[3], 'fav_playlist' => $user_data_index[4] );
    } else {
      $user_data_show = array( 'p_pic' => 'checked', 'f_song' => 'unchecked', 'email_pub' => 'unchecked', 'fav_album' => 'unchecked', 'fav_playlist' => 'unchecked' );
    }
    array_push($user_data_show, $user_data);
  }
}

?>