<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_email = mysqli_real_escape_string( $link, $_POST['user_email'] );
    $user_name = mysqli_real_escape_string( $link,  $_POST['user_name'] );
    $user_pass = mysqli_real_escape_string( $link,  $_POST['user_pass'] );
    $user_confirm_pass = mysqli_real_escape_string( $link, $_POST['user_confirm_pass'] );

    function checkData( $common ) {

      $user_email = mysqli_real_escape_string( $GLOBALS['link'], $_POST['user_email'] );
      $user_name = mysqli_real_escape_string( $GLOBALS['link'],  $_POST['user_name'] );
      $user_pass = mysqli_real_escape_string( $GLOBALS['link'],  $_POST['user_pass'] );
      $user_confirm_pass = mysqli_real_escape_string( $GLOBALS['link'], $_POST['user_confirm_pass'] );

      $result = $common->execute_query( "SELECT email FROM wt_users where email='".$user_email."'" );
      if( !$result ) {
        $numResults = 0;
      } else {
        $numResults = mysqli_num_rows( $result );
      }
      
      

      if(strlen($user_name) < 3 && ctype_alpha($user_name)){
        $error[] = 'Username is too short.';
      }

      if (!preg_match("/^[a-zA-Z ]*$/",$user_name)) {
        $error[] = "name can only contains letters and white space";
      }

      if($user_pass != $user_confirm_pass){
        $error[] = 'passwords do not match.';
      }

      if(strlen($user_pass) < 5){
        $error[] = 'password should be greater than 6 character.';
      }

      if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $error[] =  "Invalid email address please type a valid email!!";
      } elseif($numResults>=1){
        $error[] = $user_email." Email already exist!!";
      }

      $domains = array ('aim.com','aol.com','att.net','bellsouth.net','btinternet.com',
            'charter.net','comcast.com', 'comcast.net','cox.net','earthlink.net',
            'gmail.com','googlemail.com', 'icloud.com','mac.com','me.com','msn.com',
            'optonline.net','optusnet.com.au', 'rocketmail.com','rogers.com','sbcglobal.net',
            'shaw.ca','sympatico.ca','telus.net','verizon.net','ymail.com', 'hotmail.com', 'rediffmail.com', 'yahoo.com', 'mail.com', 'outlook.ocm');

      $topLevelDomains = array ('com', 'com.au', 'com.tw', 'ca', 'co.nz', 'co.uk', 'de',
            'fr', 'it', 'ru', 'net', 'org', 'edu', 'gov', 'jp', 'nl', 'kr', 'se', 'eu',
            'ie', 'co.il', 'us', 'at', 'be', 'dk', 'hk', 'es', 'gr', 'ch', 'no', 'cz',
            'in', 'net', 'net.au', 'info', 'biz', 'mil', 'co.jp', 'sg', 'hu');

      $emailTopDomain = substr($user_email, strrpos($user_email, '.') + 1);
      $emailDomain = substr($user_email, strrpos($user_email, '@') + 1);
      if(in_array($emailTopDomain, $topLevelDomains) && in_array($emailDomain, $domains)) {

      } else {
        $error[] = "we are not accepting this domain of emails, please use another domain";
      }

      if(isset($error)) {
        return array( $error );
      } else {
        $error[] = "check-success";
        return array(  $error );
      }
      
    }

    list( $returnedVal ) = checkData( $common );

    $errors = array_filter($returnedVal);
    if ($returnedVal[0] == "check-success" ) {

      $token = uniqid();

      $parts = explode(" ", $user_name, 2);
      $firstname = $parts[0];
      if( count($parts) == 2 ) $lastname = $parts[1]; else $lastname="";
      $emailparts = explode('@', $user_email);
      $unique_user_name = $emailparts[0];

      $create_user = mysqli_query($link, "insert into wt_users(name, unique_user_name, firstname, lastname, email,password, pass_token) values('".$user_name."', '".$unique_user_name."', '".$firstname."', '".$lastname."', '".$user_email."','".md5($salt . $user_pass)."', '$token')");
      if (!$create_user) {
        die('Error in Signup: ' . mysqli_error());
      } else $success = "success";

      $bodyMessage = "Greetings from wtsongs.com,<br><br> You have successfully assigned with wtsongs.com<br> To finally activate your registration with us, please click on following link<br><br>
      <a href=\"" . baseUrl . "/usersquery/?confirm_reg=$token&email=$user_email\">" . baseUrl . "/usersquery/?confirm_reg=$token&email=$user_email</a><br><br>
      If clicking the link doesn't work you can copy the link into your browser window or type it there directly.<br><br>
      Regards<br>
      <i>Your <b>wtsongs</b> Team</i><br>-----------------------------<br><a href=\"/\" target=\"_blank\">www.wtsongs.com</a><br><br><b>WTSONGS</b> Gwalior, Madhya Pradesh (India)<br>Pin - 474001, Tel - 0751-4044148";

      if( sendConfirmail( array($user_email, "Confirm wtsongs registration", "info@wtsongs.com", $bodyMessage) ) ) echo $success;
      else $error[] = "Some Technical Error! Mail could't be sent";
    } else {
      foreach ($returnedVal as $key => $value) {
        echo $returnedVal[$key] . "\n";
      }
    }

  } else {
    $error[] = "Wrong Request";
  }
?>