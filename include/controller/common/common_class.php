<?php

if( defined('DB_NAME') ) {
  // database file included
} else {
  //include database file
  require_once $_SERVER['DOCUMENT_ROOT'] . "/include/controller/db/DBConfig.php";
}

class commonClass {

  public $userId;
  public $userEmail;

  function existselectquery( $query ) {

    $check = "$query";
    echo $check;
  }

  //check if an query is executed or not
  function checkquery($result) {
    if (!$result) {
      die('Invalid query: ' . mysqli_error());
    } else return true;
  }

  //trim data
  function testitle($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  //get playlist id by playlist title associated with user_id
  function getplid($data) {
    $sqlresult = mysqli_query( $GLOBALS['link'], "SELECT * FROM wt_playlists WHERE playlist_title='$data' AND user_id=" . $GLOBALS['user_id'] );
    if( $this->checkquery($sqlresult) ) {
      $sqlrow = mysqli_fetch_assoc($sqlresult);
      return $sqlrow['playlist_id'];
    }
  }

  //check track exist in playlist
  function checkTrackExistinPlaylist($data) {
    $query = mysqli_query( $GLOBALS['link'], "SELECT * FROM wt_playlist_data, wt_playlists WHERE wt_playlist_data.playlist_id='$data[0]' AND track_id='$data[1]'" );
    if( $this->checkquery($query) ) {
      if( mysqli_num_rows( $query ) > 0 ) {
        return true;
      } else return false;
    } else echo "query not executed";
  }

  //get all track of a playlist
  function getalltrackofplaylist($data) {
    if( is_numeric($data) ) {
      $allTrackId = mysqli_query( $GLOBALS['link'], "SELECT track_id FROM wt_playlist_data AS pd WHERE pd.playlist_id='$data'" );
      if( $this->checkquery($allTrackId) ) {
        if( mysqli_num_rows($allTrackId) > 0 ) {
          while ( $trackResult = mysqli_fetch_assoc($allTrackId) ) {
            $track_ids[] = $trackResult['track_id'];
          } return array( $track_ids );
        }
      }      
    }
  }

  /* //get all track of a album
  function getalltrackofalbum($data) {
    if( is_numeric($data) ) {
      $allTrackId = mysqli_query( $GLOBALS['link'], "SELECT track_id FROM " )
    }
  } */

  //check for playlist is exist in wt_playlists table
  function is_pl_exist($data) {
    if( is_numeric($data) ) {
      $plExistSql = mysqli_query( $GLOBALS['link'], "SELECT * FROM wt_playlists WHERE playlist_id='$data'" );
      if( mysqli_num_rows($plExistSql) > 0 ) {
        return true;
      } else return false;
    } else {
      $plExistSql = mysqli_query( $GLOBALS['link'], "SELECT * FROM wt_playlists WHERE playlist_title='$data'" );
      if( mysqli_num_rows($plExistSql) > 0 ) {
        return true;
      } else return false;
    }
  }

  //check if track is exsit in wt_tracks table
  function is_track_exist($data) {
    if( is_numeric($data) ) {
      $trExist = mysqli_query( $GLOBALS['link'], "SELECT * FROM wt_tracks WHERE track_id='$data'" );
      if( mysqli_num_rows($trExist) > 0 ) {
        return true;
      } else {
        return false;
      }
    } else {
      $trExist = mysqli_query( $GLOBALS['link'], "SELECT * FROM wt_tracks WHERE track_title='$data'" );
      if( mysqli_num_rows($trExist) > 0 ) {
        return true;
      } else return false;
    }
  }

  //check if an album exist in a database
  function is_al_exist($data) {
    if( is_numeric($data) ) {
      $alExistSql = mysqli_query( $GLOBALS['link'], "SELECT * FROM wt_albums WHERE album_id='$data'" );
      if( mysqli_num_rows( $alExistSql ) > 0 ) {
        return true;
      } else return false;
    } else {
      $alExistSql = mysqli_query( $GLOBALS['link'], "SELECT * FROM wt_albums WHERE album_title='$data'" );
      if( mysqli_num_rows($alExistSql) > 0 ) {
        return true;
      } else return false;
    }
  }

  //add to favourite data in user favourite
  function addtofavpl(array $data) {
    if( $this->checkForExistFav($data) ) {
      return false;
    } else {
      $addTrackResult = mysqli_query( $GLOBALS['link'], "INSERT INTO wt_usermeta (user_id, term_id, object_id, is_fav) VALUES('" . $GLOBALS['user_id'] . "', '$data[0]', '$data[1]', '1')" );
      if( $this->checkquery($addTrackResult) ) {
        return true;
      }
    }
  }

  //check if a favourite data is alredey exist in users favourite
  function checkForExistFav( $data ) {

    $checkExistance = mysqli_query( $GLOBALS['link'], "SELECT meta_id FROM wt_usermeta WHERE term_id='$data[0]' AND object_id='$data[1]' AND user_id='" . $GLOBALS['user_id'] . "'" );
    if( mysqli_num_rows($checkExistance) > 0 ) {
      $deleteExistTrack = mysqli_query( $GLOBALS['link'], "DELETE FROM wt_usermeta WHERE term_id='$data[0]' AND object_id='$data[1]' AND user_id='" . $GLOBALS['user_id'] . "'" );
      return true;
    } else return false;
  }

  //deletedata
  function deleteNormalData( $data ) {
    if( count($data) == 3 ) {
      $dQUERY = mysqli_query( $GLOBALS['link'], "DELETE FROM $data[0] WHERE $data[1]='" . $data[2] . "'" );
      if( $this->checkquery($dQUERY) ) {
        return true;
      } else return false;
    } elseif( count($data) == 5 ) {
      $dQUERY = mysqli_query( $GLOBALS['link'], "DELETE FROM $data[0] WHERE $data[1]='" . $data[2] . "' AND $data[3]='" . $data[4] . "'" );
      if( $this->checkquery($dQUERY) ) {
        return true;
      } else return false;
    } else return false;
  }

  //get all detail of an album
  function getAlDetail($data) {
    if( is_numeric($data) ) {
      $alDetailSql = mysqli_query( $GLOBALS['link'], "SELECT * FROM wt_albums where album_id='$data'" );
      if( mysqli_num_rows($alDetailSql) > 0 ) {
        return true;
      } else return false;
    } else {
      $alDetailSql = mysqli_query( $GLOBALS['link'], "SELECT * FROM wt_albums WHERE album_title='$data'" );
      if( mysqli_num_rows($alDetailSql) > 0 ) {
        return true;
      } else return false;
    }
  }

  function datadetail($data) {
    $dataSql = mysqli_query( $GLOBALS['link'], "SELECT * FROM $data[0] WHERE $data[1]='$data[2]'" );
    if( mysqli_num_rows($dataSql) > 0 ) {
      $tableCol = mysqli_query( $GLOBALS['link'], "SHOW columns FROM ". $data[0]);
      while( $tablerow = mysqli_fetch_assoc($tableCol) ) {
        $col[] = $tablerow['Field'];
      }
      $i = 0;
      while( $dataRow = mysqli_fetch_assoc($dataSql) ) {
        foreach ($col as $key => $value) {
          $dataval[$value][] = $dataRow[$value];
        }
      }
      return array( $dataval );
    } else return false;
  }

  //execute query and return true of false if query executed
  function query_execute($data) {
    $ex_query = mysqli_query( $GLOBALS['link'], $data );
    if( $this->checkquery($ex_query) ) {
      return true;
    } else false;

  }

  //execute query and return result
  function execute_query( $data ) {
    $query_result = mysqli_query( $GLOBALS['link'], $data );
    if( $this->checkquery($query_result) ) {
      return $query_result;
    } else return false;
  }

  function checkFavOnloadAlbum($data, $term_id) {
    $checkAlbum = mysqli_query( $GLOBALS['link'], "SELECT * FROM wt_usermeta WHERE term_id='$term_id' AND object_id='$data' AND user_id='" . $GLOBALS['user_id'] . "'" );
    if( mysqli_num_rows($checkAlbum) > 0 ) {
      return true;
    } else return false;
  }

  function createPlaylist($ptitle, $preleased) {
    $createpl = mysqli_query( $GLOBALS['link'], "INSERT INTO wt_playlists (seokey, playlist_title, creation_date, term_id, lang_id, user_id, released) VALUES( '$ptitle', '$ptitle', '" . date("Y-m-d") . "', '9', '2', '" . $GLOBALS['user_id'] . "', '$preleased' )" );
    if( $this->checkquery($createpl) ) {
      return true;
    } else echo "playlist could not be created";
  }

  //check for email Existance in domain
  function emailValidation( $data ) {

    $user_email = $data;

    $domains = array ('aim.com','aol.com','att.net','bellsouth.net','btinternet.com',
            'charter.net','comcast.com', 'comcast.net','cox.net','earthlink.net',
            'gmail.com','googlemail.com', 'icloud.com','mac.com','me.com','msn.com',
            'optonline.net','optusnet.com.au', 'rocketmail.com','rogers.com','sbcglobal.net',
            'shaw.ca','sympatico.ca','telus.net','verizon.net','ymail.com', 'hotmail.com', 'rediffmail.com', 'yahoo.com', 'mail.com', 'outlook.ocm');

    $topLevelDomains = array ('com', 'com.au', 'com.tw', 'ca', 'co.nz', 'co.uk', 'de',
            'fr', 'it', 'ru', 'net', 'org', 'edu', 'gov', 'jp', 'nl', 'kr', 'se', 'eu',
            'ie', 'co.il', 'us', 'at', 'be', 'dk', 'hk', 'es', 'gr', 'ch', 'no', 'cz',
            'in', 'net', 'net.au', 'info', 'biz', 'mil', 'co.jp', 'sg', 'hu');

    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
      return "invalidEmail";
    } elseif( strpos($user_email, '@') !== false && strlen($user_email) > 5 && strpos($user_email, '.') ) {

      $emailTopDomain = substr($user_email, strrpos($user_email, '.') + 1);
      $emailDomain = substr($user_email, strrpos($user_email, '@') + 1);

      if(in_array($emailTopDomain, $topLevelDomains) && in_array($emailDomain, $domains)) {
        return true;
      } else {
        unset( $domains, $topLevelDomains, $emailTopDomain, $emailDomain );
        return "invalideDomain";
      } 
    } else return "invalidEmail";    
  }

  /*
    @ check if user is logged_in via facebook
    @ if logged in then return their facebook id
  */
  function check_fb_user($user_id) {
    $fb_user_result = $this->execute_query( "SELECT fb_id FROM wt_users as u WHERE u.id='$user_id'" );
    if( $fb_user_result !== false && mysqli_num_rows($fb_user_result) == 1 ) {
      $fb_id = mysqli_fetch_assoc($fb_user_result);
      if( strlen($fb_id['fb_id']) > 5 )
        return $fb_id['fb_id'];
      else return false;
    } else {
      return false;
    }
  }

  //check if email_already_exist in our system
  function email_exist( $email_id ) {
    $email_result = $this->execute_query( "SELECT email FROM wt_users as u WHERE u.email='$email_id'" );
    if( mysqli_num_rows($email_result) == 1 ) {
      return true;
    } else return false;
  }

  public function __construct() {
    if( isset($_SESSION['name']) && isset($_SESSION['user_id']) ) {
      $this->userEmail = $GLOBALS['user_email'];
      $this->userId = $GLOBALS['user_id'];
    }    
  }

}

?>