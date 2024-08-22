<?php  
  if( isset($_POST['name']) ) {
    if( strlen( $_POST['name'] ) < 3 ) {
      $fderror[] = "Your name must be greater than 3 Character";
    } else {
      if( ctype_alpha($_POST['name']) )
        $name = $_POST['name'];
      else $fderror[] = "Name can only contain alphanumeric characters";
    } 
  } else $fderror[] = "Name is Required";

  if( isset($_POST['email']) && strpos($_POST['email'], '@') !== false && strlen($_POST['email']) > 5 && strpos($_POST['email'], '.') ) {
    $email_result = $common->emailValidation( $_POST['email'] );
    if( $email_result === true ) {
      $email = $_POST['email'];
    } else {
      $fderror[] = "Email is not correct, Please check your email";
    }
  } else $fderror[] = "Email is not correct";

  if( isset($_POST['cat']) ) {
    $cat = $_POST['cat'];
  } else $fderror[] = "Cateogory selection is must required";

  if( isset($_POST['matter']) && strlen($_POST['matter']) > 10 ) {
    $matter = $_POST['matter'];
  } else $fderror[] = "Must write matter in more detail! ";

  if( empty($fderror) ) {

    //email data
    $email = array('to' => 'info@wtsongs.com', 'subject' => $cat, 'from' => $email, 'body' => $matter );

    if( sendmail( $email ) ) {
      echo "success";
    } else $fderror[] = "Some Technical Error! Mail could't be sent";

  } else {
    foreach ($fderror as $key => $value) {
      echo $value . "\n";
    }
  }
?>