<?php
$x = 8;
$y = 5;
$cookie_name = "song[" . $x . "]";
echo $cookie_name;
if( !isset($_COOKIE['song'][0]) ) {
  echo "cookie is not set";
} else echo "cookie is set";
setcookie($cookie_name, "1111");
setcookie("song[$x]", '2222');
setcookie('song[2]', '3333');
setcookie('song[3]', '4444');
setcookie('song[4]', '5555');
setcookie('song[' . $y . ']', '88888');
?>
<html>
<body>

<?php

print_r($_COOKIE['song']);

echo "<br>";

echo count($_COOKIE['song']) . "<br>";

foreach ($_COOKIE['song'] as $key => $value) {
  echo $key . "<br>";
  echo $_COOKIE['song'][$key] . "<br>";
}

?>

</body>
</html>