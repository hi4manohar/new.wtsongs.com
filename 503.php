<?php

header("HTTP/1.1 503 Service Temporarily Unavailable");
header("Status: 503 Service Temporarily Unavailable");
header("Retry-After: Fri, 15 Oct 2015 6:00:00 GMT");

?>

<center>
  <h1>wtsongs is currently down!</h1>
  <p>At this time site is down due to server maintenance<br>We will be back shortly, Kindly bear with us till then.<br>Thanks, For your patience.</p>
  <p>wtsongs.com - <?php echo date("Y/m/d"); ?></p>
  <!-- <img src="http://img.wtsongs.com/images/static/maintainance.jpg"></img> -->
</center>