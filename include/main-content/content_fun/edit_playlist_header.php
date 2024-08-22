<!-- editing header -->
<div class="album_header_containner seogiUI">
  <div class="album_containner_inner">
  	<div class="user_e_p">
  		<img src="/assets/img/edit_icon.png">
  		<span>Edit Your Playlist</span>
  	</div>
    <div class="clearfix"></div>
    <form name="editheader" onsubmit="return editplaylist();" style="margin-left:40px;">
  	<input type="text" name="newPlName" value="<?php echo ucwords(plTitle); ?>" placeholder="<?php echo ucwords(plTitle); ?>" class="e_p_name updatepl" data-value="<?php echo $ehData['pl_id']; ?>" autocomplete="off"></input>
  	<div class="clearfix"></div>
  	<div class="user_p_v">
  	<span>Visibility :</span>
  	<input id="ispublicheader" type="checkbox" value="1" <?php echo ( $ehData['released'] == 1 ) ? " checked" : ""; ?>>
  	<p>( Checked will be shown to publicily, Unchecked will be private to you )</p>
  	<div class="clearfix"></div>
  	<p class="user_p_length">Songs: <?php echo $ehData['total_track']; ?> | Created On: <?php $date = date_create( $ehData['created_on'] ); echo date_format($date,"d-m-Y"); ?></p>
  	</div>
  	<button class="user_p_save" name="submit" value="save">save</button>
    </form>
    <a href="<?php echo str_replace( '/playlists/editplaylists/', '/playlists/', page_url ); ?>" data-pjax="#main" data-push="true" data-target="#main">
    <button class="user_p_cancel cancelEdit" value="cancel" gotourl="/<?php echo $playlist['user'] . "/" . $this->pl_url; ?>">cancel</button>
    </a>
  </div>
</div>