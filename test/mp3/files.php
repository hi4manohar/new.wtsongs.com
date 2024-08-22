<?php

include 'getID3Tag/getID3-master/getID3-master/getid3/getid3.php';
//include 'db_config/DBConfig.php';
$id3 = new getID3();

  function listFolderFiles($dir){
    global $id3;
    $ffs = scandir($dir);
    $lastFile = basename ( $dir );
    echo $lastFile;
    echo '<ol>';
    foreach($ffs as $ff){
      if($ff != '.' && $ff != '..'){
        $ext = pathinfo($ff, PATHINFO_EXTENSION);
        if($ext == "mp3") {      
          echo '<li>' . $ff;
          //$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $ff);
          //echo $ff . "<br>";

          //get Album Id of The Album          
          //$getAlbumId = "SELECT album_id FROM wt_albums WHERE album_title='$lastFile'";
          //$result = mysqli_query($link, $getAlbumId);
          //while($row = mysqli_fetch_assoc($result)) {
            //echo $row["album_id"] . "<br>";
          //}

          //$mp3File = $dir . "/" . $ff;
          //$data = $id3->analyze( $mp3File );
          //if(isset($data['tags']['id3v2']['artist'][0])) {
            //$artist = $data['tags']['id3v2']['artist'][0];
          //} else {
            //$artist = "NA";
          //}          
          //echo $artist . "<br>";


        }
        if(is_dir($dir.'/'.$ff)) {
          $dirName = $ff;
          listFolderFiles($dir.'/'.$ff) . "<br>";
        }
        echo '</li>';
      }
    }
    echo '</ol>';
  }
  listFolderFiles('C:\hindi album\R');
?>