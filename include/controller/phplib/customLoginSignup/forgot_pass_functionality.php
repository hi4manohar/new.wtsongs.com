<?php
  if(isset($_POST['user_email'])) {
    $userEmail = $_POST['user_email'];
    //validate email
    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
      $error =  "invalid email address please type a valid email!!";
      echo $error;
    } else {
      $query = "SELECT id FROM wt_users WHERE email='" . $userEmail . "'";
      $result = mysqli_query($link, $query);

      if(mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result) ) {
          $user_id = $row['id'];
        }

        $token = md5(uniqid());

        $sql = "UPDATE wt_users SET pass_token='" . $token ."' WHERE id=$user_id";

        //insert token
        mysqli_query($link, $sql);

        //send mail
        $to = $userEmail;
        $subject = "Reset wtsongs Password";
        $from = "info@wtsongs.com";
        $body = 'Greetings from wtsongs.com,<br> You have just requested to generate a new password through forgot your password.<br><br>
        Now you can reset your password to follow the below link :<br><br>
        <a href="' . baseUrl . '/usersquery/?forgotpassword=' . $token . '">' . baseUrl . '/usersquery/?forgotpassword=' . $token . '<br></a>
        <br>If clicking the link doesn\'t work you can copy the link into your browser window or type it there directly.<br><br>
        Regards<br>
        <i>Your <b>wtsongs</b> Team</i><br>-----------------------------<br><a href="/" target="_blank">www.wtsongs.com</a><br><br><b>WTSONGS</b> Gwalior, Madhya Pradesh (India)<br>Pin - 474001, Tel - 0751-4044148';
        $headers = "From: " . strip_tags($from) . "\r\n";
        $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        mail($to, $subject, $body, $headers);

      } else {
        $error = "your account could't found please signup now!!";
      }

      //return status
      if(isset($error)) {
        echo $error;
      } else {
        echo "success";
      }
    }
  }
?>