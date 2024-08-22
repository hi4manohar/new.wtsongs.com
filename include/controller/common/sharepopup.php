
<div class="share_popup_containner">
  <div class="share_popup_header">
    <li class="share_popup_title">
      <h1>Share</h1>
      <p>Dedicate to your relatives</p>
    </li>
    <div class="share_popup_cancel_button" onclick="hideshare()"><img src="/assets/img/cancel.png"></div>
  </div>
  <div class="share_song_detail dotes">
    <div class="share_popup_songs_image"><img src="<?php echo $s_data['data_img']; ?>"></div>
    <p><?php echo $s_data['data_title']; ?></p>
    <p class="dotes" style="font-size:11px; width:208px;"><?php echo isset($s_data['data_album']) ? $s_data['data_album'] : $s_data['data_title']; ?></p>
  </div>
  <div class="s_s_pop_wrapper">
    <div class="s_s_pop_up"></div>
  </div>
  <div class="songs_share_on">
    <p>share on social</p>
    
    <center>
    <ul class="songs_share_on_container rrssb-buttons clearfix">
      <li class="songs_share_on_icon rrssb-facebook">
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $s_data['data_url'] ?>" class="popup">
          <img src="/assets/img/facebook.png" onclick="hideshare()">
        </a>
      </li>
      <li class="songs_share_on_icon rrssb-twitter">
        <a href="https://twitter.com/intent/tweet?url=<?php echo $s_data['data_url']; ?>&text=<?php echo $s_data['data_content']; ?>&original_referer=<?php echo $s_data['data_url']; ?>&via=wtsongs&hashtags=nowplaying" class="popup" onclick="hideshare()">
          <img src="/assets/img/twitter.png">
        </a>
      </li>
      <li class="songs_share_on_icon">
        <a href="https://plus.google.com/share?url=<?php echo $s_data['data_url']; ?>" onclick="hideshare()" class="popup" onclick="hideshare()">
          <img src="/assets/img/google+.png">
        </a>
      </li>
    </ul>
    </center>
    
  </div>
  <div class="song_copy_links">
    <li class="copy_link_button">
    <a href="javascript:void(0)" onclick="window.prompt('Copy to clipboard: Ctrl+C, Enter', '<?php echo $s_data['data_url']; ?>');">
      <img src="/assets/img/copy_link.png">
      <p>copy link</p>
    </a>
    </li>
  </div>
  <div class="song_share_privetly">
  <ul class="rrssb-buttons clearfix">
    <a href="http://www.facebook.com/dialog/send?app_id=515979721894250&display=popup&link=<?php echo $s_data['data_url']; ?>&redirect_uri=<?php echo $s_data['data_url']; ?>" class="popup share_privetly ">Share privately<img src="/assets/img/privetly.png" onclick="hideshare()"></a>
  </ul>
  </div>
</div>