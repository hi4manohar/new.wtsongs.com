<div class="album_header_containner">
  <div class="album_containner_inner">
    <div class="album_containner_inner_img">
    <?php list( $headerData ) = $this->plHeaderSql(); ?>
      <img src="<?php echo $this->pAlbumImg; ?>" alt="<?php echo plTitle; ?>">
    </div>
    <a href="javascript:void(0);">
      <div class="album_player albumPlayerIcon"></div>
    </a>
    <div class="album_containner_details">
      <div class="album_details">
        <p class="album_name dotes" title="<?php echo plTitle; ?>"><?php echo ucwords(plTitle); ?></p>
        <p class="album_by dotes">Created by <?php echo $headerData['pl_user']; ?></p>
        <p class="album_length">Songs: <?php echo $headerData['total_track']; ?> | Last Update: <?php $date = date_create( $headerData['created_on'] ); echo date_format($date,"d-m-Y"); ?></p>
        <p class="album_favorites"> <?php echo $headerData['total_fav']; ?> Favorites</p>
        <p class="album_singer dotes"></p>
        <div class="button">
          <div class="download_button downloadIcon downloadHandle">
            <a href="javascript:void(0)" class="button-round" title="Download Song" data-type="download" data-value="playlist<?php echo $headerData['playlist_id']; ?>"></a>
          </div>
          <div class="comment_button commentIcon">
            <a href="javascript:void(0)" id="comment-btn" class="button-round" title="Go To comment" data-type="comment" data-value="playlist<?php echo $headerData['playlist_id']; ?>"></a>
          </div>
          <div class="favorite favouriteIcon addtofavourite playlist<?php echo $headerData['playlist_id']; ?>" data-type="favourite" data-cat="playlist" data-value="playlist<?php echo $headerData['playlist_id']; ?>" title="add to favourite">
          </div>
          <div class="add addIcon addtoplaylist addtoplaylist<?php echo $headerData['playlist_id']; ?>" data-type="addtoplaylist" data-cat="playlist" data-value="playlist<?php echo $headerData['playlist_id']; ?>" title="add to playlist">
          </div>
          <div class="share shareIcon headershare">
            <a class="shareheaderplaylist" href="javascript:void(0)" title="share" data-type="share" data-value="playlist<?php echo $headerData['playlist_id']; ?>"></a>
          </div>
        </div>        
      </div>
    </div>
    <!-- like butoon  end -->
      <div class="album_details_right">
        <div class="fb-like" data-href="https://facebook.com/wtsongs2015" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
        <div class="clearfix"></div>
        <?php if( activeEditDeletePl === true && $playlist['show_edit_del'] === true ): ?>
          <div class="u_p_e">
            <div class="u_p_e_icon">
              <img src="/assets/img/edit_icon.png">
            </div>
            <a href="/playlists/editplaylists/<?php echo $playlist['user'] . "/" . $this->pl_url; ?>" data-push="true" data-target="#main"><button class="editpl" Value="Edit">Edit</button></a>
          </div>
          <div class="u_p_d">
            <div class="u_p_e_icon">
              <img src="/assets/img/delete_icon.png">
            </div>
          <button class="deletepl" value="Delete" data-type="deleteplaylist" data-value="playlist<?php echo $headerData['playlist_id']; ?>">Delete</button>
          </div>
        <?php endif; ?>
      </div>
      <!-- like butoon  html end -->
  </div>
</div>