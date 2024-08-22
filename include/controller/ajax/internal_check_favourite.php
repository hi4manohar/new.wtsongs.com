<?php
/*
@function checks if track is in favourite list or not
@param is for array of track_ids
*/
function checkfav( array $track_data ) {
  foreach ($track_data as $key => $value) {
    $trackExistance = mysqli_query( $GLOBALS['link'], "SELECT meta_id FROM wt_usermeta WHERE user_id='" . user_id . "' AND object_id='" . $track_data[$key] . "' AND term_id='28'" );
    if(mysqli_num_rows($trackExistance) > 0) {
      $favdata[$value] = "bgred";
    } else $favdata[$value] = "";
  }
  return $favdata;
}
?>