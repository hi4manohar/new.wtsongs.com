<?php

class playlist_config {

  public function pl_do_stuff($pl_title, $common_class) {
    global $playlist;
    define('plTitle', $pl_title);
    $trim_playlist = $common_class->testitle($pl_title);

    if( isset($_GET['user']) && $_GET['user'] !== "" ) {

      $user = $common_class->testitle( $_GET['user'] );
      $pl_config = $common_class->execute_query( "SELECT pl.playlist_id, pl.user_id, pl.released, (SELECT COUNT(*) FROM wt_playlist_data as pd WHERE pl.playlist_id=pd.playlist_id  ) as tt FROM wt_playlists as pl, wt_users u WHERE pl.playlist_title='" . $trim_playlist . "' AND u.unique_user_name='$user' AND pl.user_id=u.id" );

    } else $pl_config = $common_class->execute_query( "SELECT pl.playlist_id, pl.user_id, pl.released, (SELECT COUNT(*) FROM wt_playlist_data as pd WHERE pl.playlist_id=pd.playlist_id  ) as tt FROM wt_playlists as pl WHERE pl.playlist_title='" . $trim_playlist . "' AND pl.user_id=0" );

    if( $pl_config !== false ) {

      if( mysqli_num_rows($pl_config) == 1 ) {
        $pl_result = mysqli_fetch_assoc( $pl_config );
        //check if user is going to access private playlists
        if( $this->check_for_private_access($pl_result) ) {
          //check for if user_playlist is going to accessed directly
          if( $this->pl_access($pl_result['user_id']) ) {
            $playlist['playlist_id'] = $pl_result['playlist_id'];
            $playlist['show_header'] = true;
            $playlist['comment'] = ( ($pl_result['released'] == 1) && ($pl_result['tt'] > 0) );
            $playlist['track_detail'] = ( $pl_result['tt'] == 0 ) ? false : true;
            if( logged_in === true ) {
              $playlist['show_edit_del'] = ( $pl_result['user_id'] == 0 || $pl_result['user_id'] !== user_id ) ? false : true;
              if( $playlist['show_edit_del'] === true ) {
                define('activeEditDeletePl', true);
                $playlist['user'] = $user;
              }
              else define('activeEditDeletePl', false);
            } else {
              $playlist['show_edit_del'] = false;
              define('activeEditDeletePl', false);
            }
          } else goto_errorpage();
        } else goto_errorpage();
      } else {
        //check if playlist also exist in user_id = 0
      }
    } else goto_errorpage();
  }

  public function check_for_private_access($pl_result) {
    if( $pl_result['released'] == 0 ) {
      if( logged_in === true && user_id == $pl_result['user_id'] ) {
        return true;
      } else goto_errorpage();
    } else return true;
  }

  public function pl_access( $user_id ) {
    if( $user_id == 0 && isset($_GET['user']) )
      goto_errorpage();
    elseif( $user_id > 0 && !isset($_GET['user']) )
      goto_errorpage();
    else return true;
  }
}

?>