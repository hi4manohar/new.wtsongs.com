<div class="category_page_corousal">
  <?php list( $pcData ) = $this->pcCategorySql(); ?>
  <?php foreach( $pcData['term_id'] as $key => $value ) { ?>
  <div class="category_page_discover">
  <a href="/popularcategory/<?php echo $pcData['href_url'][$key]; ?>" data-push="true" data-target="#main">
    <img src="<?php echo $pcData['img_url'][$key]; ?>" />
    <div class="category_page_discover_type">
      <a href="/popularcategory/<?php echo $pcData['href_url'][$key]; ?>" title="<?php echo $pcData['name'][$key]; ?>" data-push="true" data-target="#main"><center><?php echo $pcData['name'][$key]; ?></center></a>
    </div>
  </a>
  </div>
  <?php } ?>
</div>