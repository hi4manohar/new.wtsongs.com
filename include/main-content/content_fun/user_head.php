<div class="album_header_containner">
  <div class="album_containner_inner">
    <div class="album_containner_inner_img">
      <!--<img src="http://img.wtsongs.com/images/static/song_default_175x175.jpg"> -->
      <!-- img uploading -->
      <div id="imgContainer">
        <div id="imgArea"><img src="<?php echo $hrData['user_image']; ?>">
        <form enctype="multipart/form-data" action="/img_upload" method="post" name="image_upload_form" id="image_upload_form">
            <div class="progressBar">
              <div class="bar"></div>
              <div class="percent">0%</div>
            </div>
            <?php if( $this->show_image_uploader === true ): ?>
            <div id="imgChange"><span>Change Photo</span>
              <input type="file" accept="image/*" name="image_upload_file" id="image_upload_file">
            </div>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>
    <a href="javascript:void(0);">
    </a>
    <div class="album_containner_details">
      <div class="album_details">
        <p class="album_name dotes"><?php echo ucwords( $this->user_name ); ?></p>
        <p class="album_by dotes">Email: 
        <?php
        if( is_numeric($this->user_email) ) {
          echo 'click <a href="javascript:void(0);" onclick="addEmail();">here</a> to add your email address';
        } else echo $this->user_email;
        ?></p>
        <p class="album_length">Favourite Songs: <?php echo $hrData['total_track']; ?> | Favourite Albums: <?php echo $hrData['total_album']; ?></p>
        <p class="album_length">Favourite Playlists : <?php echo $hrData['total_pl']; ?> | Created Playlist : <?php echo $hrData['created_pl']; ?></p>
        <p class="album_singer dotes"></p>
        <div class="button">
          <div class="download_button downloadIcon">
            <a href="javascript:void(0)"></a>
          </div>
          <div class="comment_button commentIcon">
            <a href="javascript:void(0)"></a>
          </div>
          <!--
          <div class="share shareIcon headershare">
            <a class="shareheaderplaylist" href="javascript:void(0)" title="share" data-type="share" data-value="playlist24"></a>
          </div>
          -->
        </div>
      </div>
    </div>
    <!-- like butoon  end -->
      <div class="album_details_right">
        <div class="fb-like" data-href="https://facebook.com/wtsongs2015" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
      </div>
      <!-- like butoon  html end -->
  </div>
</div>