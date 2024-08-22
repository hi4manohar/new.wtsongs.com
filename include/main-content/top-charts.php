<?php

class displayTopCharts {
  public function topCollection() {
    $this->topMainContent();
  }

  function topChartsSql() {
    $tcSql = "SELECT pl.playlist_id, pl.playlist_title, COUNT(`track_id`) as tt FROM wt_playlists as pl, wt_playlist_data as pd WHERE pl.playlist_title LIKE '%top%' AND pl.playlist_id=pd.playlist_id AND pl.user_id='0' GROUP BY playlist_title";
    $tcResult = mysqli_query( $GLOBALS['link'], $tcSql );

    if( mysqli_num_rows($tcResult) > 0 ) {
      while($tcRow = mysqli_fetch_assoc($tcResult) ) {
        $tc['playlist_id'][] = $tcRow['playlist_id'];
        $tc['pl_title'][] = $tcRow['playlist_title'];
        $tc['total_track'][] = $tcRow['tt'];
      }

      foreach ($tc['playlist_id'] as $key => $value) {
        $tfquery = mysqli_query( $GLOBALS['link'], "SELECT COUNT(*) AS tf FROM wt_usermeta as u WHERE u.object_id='$value' AND u.term_id='9' " );
        $tfResult = mysqli_fetch_array($tfquery);
        $tc['total_fav'][] = $tfResult['tf'];
      }
      $imgArray = str_replace(' ', '+', $tc['pl_title']);
      foreach ($imgArray as $key => $value) {
        $fLetter = substr($imgArray[$key], 0, 1);
        $tc['pl_image'][] = "http://img.wtsongs.com/images/playlists/" . $fLetter . "/" . $tc['pl_title'][$key] . "/" . $imgArray[$key] . "_80x80.jpg";
        $tc['url'][] = $imgArray[$key];
      }
      $tc['lower_case_pl_image'] = array_map('strtolower', $tc['pl_image']);
      $tc['tc_url'] = array_map('strtolower', $tc['url']);
      return array( $tc );
    }


  }

  public function topMainContent() {
?>

<div class="top_charts_container">
  <div class="top_chart_content_wrapper">
    <?php list( $plData ) = $this->topChartsSql(); ?>
    <?php foreach ($plData['pl_title'] as $key => $value) { ?>
    <div class="top_charts_inner">
      <div class="top_charts_inner_img">
        <div class="top_charts_inner_player play_album"></div>
        <img src="<?php echo $plData['lower_case_pl_image'][$key]; ?>" alt="<?php echo $plData['pl_title'][$key]; ?>">
      </div>
      <div class="top_charts_inner_details">
        <div class="top_charts_inner_name">
          <a href="/playlists/<?php echo $plData['tc_url'][$key] ?>" title="<?php echo $plData['pl_title'][$key]; ?>" data-push="true" data-target="#main"><?php echo $plData['pl_title'][$key]; ?></a>
        </div>
        <div class="top_charts_inner_name_details">
          <a href="" title="<?php echo $plData['total_track'][$key]; ?> songs"><?php echo $plData['total_track'][$key]; ?> Songs
          <br/><?php echo $plData['total_fav'][$key]; ?> Favourites</a>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>

<?php
  }
}

?>