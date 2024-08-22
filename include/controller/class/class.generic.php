<?php

class generic_class {

  public function get_images( $type, $data, $size ) {
    $img_domain = "http://img.wtsongs.com";
    switch ($type) {
      case 'album':
        $first_letter = $this->get_url_type_string( $this->get_first_letter($data) );
        if( is_numeric($first_letter) ) $first_letter = "0-9";
        $img_arr = array(
          '1st' => $img_domain . "/images/albums/" . $first_letter . "/" . $this->get_img_type_string($data) . "/" . $this->get_url_type_string($data) . "$size.jpg",
          '2nd' => $img_domain . "/images/all/" . $first_letter . "/" . $this->get_url_type_string($data) . "$size.jpg",
          '3rd' => $img_domain . "/images/all/" . $first_letter . "/" . $this->get_url_type_string($data) . ".jpg",
          '4th' => $img_domain . "/images/all/" . $first_letter . "/" . $this->get_url_type_string($this->get_trimmed_str($data, -5)) . ".jpg"
        );

        foreach ($img_arr as $key => $value) {
          if( $this->check_img_exist($value) ) {
            return $value;
          }
        }

        return $img_domain . "/images/static/song_default" . $size . ".jpg";
        break;

      case 'playlist':
        $first_letter = $this->get_url_type_string( $this->get_first_letter($data) );
        $img_arr = array(
          '1st' => $img_domain . "/images/playlists/" . $first_letter . "/" . $this->get_img_type_string($data) . "/" . $this->get_url_type_string($data) . "$size.jpg"
        );

        foreach ($img_arr as $key => $value) {
          if( $this->check_img_exist($value) ) {
            return $value;
          }
        }

        return $img_domain . "/images/static/song_default" . $size . ".jpg";
        break;

      case 'user':
        $user_img_path = "/assets/uploades/medium/";
        $img_arr = array(
          '1st' => $img_domain . "/images/uploades/medium/" . $data['user_id'] . "/" . $data['img_name'] . ".jpg",
          '2nd' => baseUrl . $user_img_path . $data['user_id'] . "/" . $data['img_name'] . ".jpg",
          '3rd' => baseUrl . "/assets/img/default_user.jpg"
        );

        foreach ($img_arr as $key => $value) {
          if( $this->check_img_exist($value) ) {
            return $value;
          }
        }
        return $img_arr['3rd'];
        break;
      default:
        # code...
        break;
    }
  }

  public function get_first_letter($d) {
    return substr($d, 0, 1);
  }

  public function get_last_year($d) {
    return substr($d, -4);
  }

  public function get_trimmed_str($d, $c) {
    return substr($d, 0, $c);
  }

  public function get_url_type_string($s) {
    return strtolower( str_replace(' ', '+', $s) );
  }

  public function get_img_type_string($s) {
    return strtolower( str_replace(' ', '%20', $s) );
  }

  public function check_img_exist($i) {
    return ( @getimagesize($i) );
  }
}

?>