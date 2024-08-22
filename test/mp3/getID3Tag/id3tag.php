<?php
$file = "Love Dose.mp3";
include 'M:/xampp/htdocs/sites/ongoing/try.com/wtsongs/getID3Tag/getID3-master/getID3-master/getid3/getid3.php';
$id3 = new getID3();
$data = $id3->analyze( $file );
//print_r($data);
$filesize = $data['filesize'];
$filesize = $filesize/1024/1024;
echo round($filesize, 2) . "MB<br>";
echo $data['filename'] . "<br>";
echo $data['playtime_string'] . "<br>";
echo $data['tags']['id3v2']['artist'][0] . "<br>";
echo $data['tags']['id3v1']['title'][0] . "<br>";
echo $data['tags']['id3v1']['album'][0] . "<br>";
echo $data['tags']['id3v1']['year'][0] . "<br>";
print_r($data['tags']['id3v1']) . "<br>";
$Path=$file;
$getID3 = new getID3;
if(isset($data['comments']['picture'][0])){
   $Image='data:'.$data['comments']['picture'][0]['image_mime'].';charset=utf-8;base64,'.base64_encode($data['comments']['picture'][0]['data']);
}
  
?>
<img id="FileImage" width="150" src="<?php echo @$Image;?>" height="150">