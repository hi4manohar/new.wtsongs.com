<!-- ===== discover part html start ==== -->
<div class="discover_container">
  <div class="discover_heading"><a  class="heading" href="/popularcategory/" data-push="true" data-target="#main" title="Browse Popular Categories">Discover</a>
  </div>
  <div class="discover_corousal">
    <div class="discover_corousal_inner imageWrapper">
    <?php list( $dsData ) = $this->discoverSql();
    ?>
    <?php foreach( $dsData['content'] as $key => $value ) { ?>
      <!--1-->
      <div class="discover">
        <img src="<?php echo $dsData['img'][$key]; ?>" />
        <div class="discover_type">
          <center><a href="#" title="<?php echo $value; ?>" data-push="true" data-target="#main"><?php echo $value; ?></a></center>
        </div>
      </div>
      <?php } ?>
    </div>
    <div class="discover_left_button controlSlideLeft">
      <div class="discover_prev_button">
        <img src="assets/img/prev_arrow.png">
      </div>
    </div>
    <div class="discover_right_button controlSlideRight">
      <div class="discover_next_button">
        <img src="assets/img/next_arrow.png">
      </div>
    </div>
  </div>
</div>
<!-- ===== discover part html start ==== -->