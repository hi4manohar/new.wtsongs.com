<?php

if( isset($_GET['id']) && $_GET['id'] !== "" && is_numeric($_GET['id']) ) {
	//include required files
	$rootDir =  $_SERVER['DOCUMENT_ROOT'];
	
	//include coomontopfile
	require_once $rootDir . '/include/controller/class/class.top.php';
	$session_param = new top_of_page();
	require_once $rootDir . '/include/controller/db/DBConfig.php';
	require_once $rootDir . '/include/controller/common/common_class.php';
	$common = new commonClass();

	//stream data
	if( isset($_GET['do']) && $_GET['do'] == "stream" ) {
		$sdata = $common->execute_query("SELECT wt.meta_track, al.album_title, l.lang_title FROM wt_albums as al, wt_tracks as wt, wt_lang as l WHERE wt.track_id='" . $_GET['id'] . "' AND al.album_id=wt.album_id AND l.lang_id=al.lang_id LIMIT 1");
		if( mysqli_num_rows($sdata) == 1 ) {
			$sdata = mysqli_fetch_assoc($sdata);
			$alLetter = substr($sdata['album_title'], 0, 1);
			if( is_numeric($alLetter) ) $alLetter = "0-9";
			$output['data'] = "http://cdn.wtsongs.com/song_category/64/" . strtolower($sdata['lang_title']) . "/" . $alLetter . "/" . $sdata['album_title'] . "/" . $sdata['meta_track'];
			$output['url'] = "http://cdn.wtsongs.com/stream.php?l=" . strtolower($sdata['lang_title']) . "&a=" . $sdata['album_title'] . "&t=" . $sdata['meta_track'];
			echo $output['url'];
			exit();
		} else {
			echo "failed";
			exit();
		}
	}

	//detecting if user is accessing from mobile

	$useragent=$_SERVER['HTTP_USER_AGENT'];
	$c = preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4));

	if( logged_in === true || $c ) {
		require_once $rootDir . '/include/controller/common/common-container.php';
		$common_container = new commonBar();
		//get album and song
		$dData = $common->execute_query("SELECT wt.meta_track, al.album_title, l.lang_title FROM wt_albums as al, wt_tracks as wt, wt_lang as l WHERE wt.track_id='" . $_GET['id'] . "' AND al.album_id=wt.album_id AND l.lang_id=al.lang_id LIMIT 1");
	
		if( mysqli_num_rows($dData) == 1 ) {
			$dData = mysqli_fetch_assoc($dData);
			$alLetter = substr($dData['album_title'], 0, 1);
			if( is_numeric($alLetter) ) $alLetter = "0-9";

			//update download_hits
			if( $common_container->update_a_or_pl_hits( $_GET['id'], "song" ) ) {
			} else {
				echo '<script>alert("There is an error with this song, Redirecting to wtsongs.com");</script>';
			}

			//insert or update user total download hits
			$total_download_user = $common->execute_query("SELECT meta_id FROM wt_usermeta WHERE user_id=" . user_id . " AND term_id=45 LIMIT 1");
			if( mysqli_num_rows($total_download_user) == 1 ) {
				//update total song downloaded by user
				if( $common_container->update_a_or_pl_hits( user_id, "download_song_by_user" ) ) {} else {
					echo '<script>alert("cannot update utds");</script>';
				}
			} else {
				//insert total downloaded song by user
				if( $common->query_execute("INSERT INTO wt_usermeta( `user_id`, `term_id`, `object_id`, `is_fav` ) VALUES('" . user_id . "', '45', '1', '0')") ) {}
					else {
					echo '<script>alert("cannot inserted utds");</script>';
				}				
			}
		} else echo '<script>alert("There is an error with this song, Please visit some time later when this song will be available");</script>';
	} else {
		echo "<h1><center>To download songs on wtsongs.com, you must have to be loggedin</center></h1>";
		exit();
	} 
} else{
	exit();
}

/*
|-----------------
| Chip Error Manipulation
|------------------
*/

error_reporting(-1);

/*
|-----------------
| Chip Constant Manipulation
|------------------
*/
//for localhost
//define( "CHIP_DEMO_FSROOT",				"L:\song_category/" );
//for live
define( "CHIP_DEMO_FSROOT", "/home/wortechs/public_html/wtsongs/sub_domains/cdn.wtsongs.com/song_category/64/" );

/*
|-----------------
| Chip Download Class
|------------------
*/

require_once("class.chip_download.php");

/*
|-----------------
| Class Instance
|------------------
*/

$download_path = CHIP_DEMO_FSROOT . strtolower($dData['lang_title']) . "/" . $alLetter . "/" . $dData['album_title'] . "/";
$file = $dData['meta_track'];

$args = array(
		'download_path'		=>	$download_path,
		'file'				=>	$file,		
		'extension_check'	=>	TRUE,
		'referrer_check'	=>	FALSE,
		'referrer'			=>	NULL,
		);
$download = new chip_download( $args );

/*
|-----------------
| Pre Download Hook
|------------------
*/

$download_hook = $download->get_download_hook();
//$download->chip_print($download_hook);
//exit;

/*
|-----------------
| Download
|------------------
*/

if( $download_hook['download'] == TRUE ) {

	/* You can write your logic before proceeding to download */
	
	/* Let's download file */
	$download->get_download();

} else echo "<center><h2>Sorry! we couldn't found files</h2></center>";
?>