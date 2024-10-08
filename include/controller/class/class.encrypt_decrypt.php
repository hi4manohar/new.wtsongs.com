<?php

$common_class_file = $_SERVER['DOCUMENT_ROOT'] . "/include/controller/common/common_class.php";
class_exists("commonClass") ? "" : require_once( $common_class_file );

class Encryption extends commonClass {
  var $skey = "de7DKe8cmE8c0K@kdn4kcney@"; // you can change it

  public  function safe_b64encode($string) {
    $data = base64_encode($string);
    $data = str_replace(array('+','/','='),array('-','_',''),$data);
    return $data;
  }

  public function safe_b64decode($string) {
    $data = str_replace(array('-','_'),array('+','/'),$string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    return base64_decode($data);
  }

  public  function encode($value){ 
    if(!$value){return false;}
    $text = $value;
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
    return trim($this->safe_b64encode($crypttext)); 
  }

  public function decode($value){
    if(!$value){return false;}
    $crypttext = $this->safe_b64decode($value); 
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
    return trim($decrypttext);
  }
}

/* example

$str = "bakchod";

$converter = new Encryption;
$encoded = $converter->encode($str );
$decoded = $converter->decode($encoded);

*/

?>