<?php 
ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
$dbname = "itm_mis1";
/*$connection=mysql_connect("itm-moodle.cbyp2s1izvrb.us-east-1.rds.amazonaws.com","itm_moodle","!tmUn!v3r$!ty");*/
$connection=mysql_connect("localhost","root","!tmm!$");
$db=mysql_select_db($dbname, $connection);    //*******for local connection ********

/*
$dbname = "examitmu";
$connection=mysql_connect("examitmu.db.7539717.hostedresource.com","examitmu","FQwr%014Gj");
$db=mysql_select_db($dbname, $connection);    //*******for local connection ********
*/
?> 