<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/controller/class/class.top.php';
$top = new top_of_page();
require_once root_dir . '/include/controller/db/DBConfig.php';
include root_dir . '/include/controller/phplib/img.upload/functions.php';
/*defined settings - start*/
ini_set("memory_limit", "99M");
ini_set('post_max_size', '2M');
ini_set('max_execution_time', 600);
define('IMAGE_SMALL_DIR', root_dir . '/assets/uploades/small/' . user_id . "/");
define('IMAGE_SMALL_SIZE', 50);
define('IMAGE_MEDIUM_DIR', root_dir . '/assets/uploades/medium/' . user_id . "/");
define('IMAGE_MEDIUM_SIZE', 250);
/*defined settings - end*/

if(isset($_FILES['image_upload_file'])){
	$output['status']=FALSE;
	set_time_limit(0);
	$allowedImageType = array("image/gif",   "image/jpeg",   "image/pjpeg",   "image/png",   "image/x-png"  );
	
	if ($_FILES['image_upload_file']["error"] > 0) {
		$output['error']= "Error in File";
	}
	elseif (!in_array($_FILES['image_upload_file']["type"], $allowedImageType)) {
		$output['error']= "You can only upload JPG, PNG and GIF file";
	}
	elseif (round($_FILES['image_upload_file']["size"] / 1024) > 2048) {
		$output['error']= "You can upload file size up to 2 MB";
	} else {
		/*create directory with 777 permission if not exist - start*/
		createDir(IMAGE_SMALL_DIR);
		createDir(IMAGE_MEDIUM_DIR);
		/*create directory with 777 permission if not exist - end*/
		$path[0] = $_FILES['image_upload_file']['tmp_name'];
		$file = pathinfo($_FILES['image_upload_file']['name']);
		$fileType = $file["extension"];
		$desiredExt='jpg';
		$fileNameNew = rand(333, 999) . time() . ".$desiredExt";
		$path[1] = IMAGE_MEDIUM_DIR . $fileNameNew;
		$path[2] = IMAGE_SMALL_DIR . $fileNameNew;
		
		if (createThumb($path[0], $path[1], $fileType, IMAGE_MEDIUM_SIZE, IMAGE_MEDIUM_SIZE,IMAGE_MEDIUM_SIZE)) {
			
			if (createThumb($path[1], $path[2],"$desiredExt", IMAGE_SMALL_SIZE, IMAGE_SMALL_SIZE,IMAGE_SMALL_SIZE)) {

        //update to db
        $imgName = substr($fileNameNew, 0, -4);

        $imgSql = mysqli_query( $link, "SELECT * FROM wt_usermeta WHERE user_id='" . $top->user_id . "' AND term_id='29'" );
        if( mysqli_num_rows($imgSql) > 0 ) {
          $imgUpdateSql = mysqli_query( $link, "UPDATE wt_usermeta SET object_id='" . $imgName . "' WHERE user_id='" . $top->user_id . "' AND term_id='29'" );
        } else {
          $newUserImg = mysqli_query( $link, "INSERT INTO wt_usermeta (user_id, term_id, object_id, is_fav) VALUES('$top->user_id', '29', '$imgName', '0')" );
        }

				$output['status']=TRUE;
				$output['image_medium']= baseUrl . "/assets/uploades/medium/" . user_id . "/" . $fileNameNew;
				$output['image_small']= $path[2];
			}
		}
	}
	echo json_encode($output);
}
?>	