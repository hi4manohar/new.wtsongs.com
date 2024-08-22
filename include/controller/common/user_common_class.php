<?php

class userCommonClass {
  public $user_id;
  public $userEmail;

  function checkuserDataExist($table, $where) {

    $check = mysqli_query( $GLOBALS['link'], "SELECT * FROM $table where $where" );

    if( mysqli_num_rows($check) > 0 ) {
      return true;
    } else {
      return false;
    }
  }

  public function __construct() {
    $this->userEmail = $GLOBALS['user_email'];
    $this->user_id = $GLOBALS['user_id'];
  }
}

?>