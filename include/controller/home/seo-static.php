<?php

class static_seo {

  function about_us_seo() {
    $this->about_us();
  }

  function about_us() {
    $this->headmeta();
    $this->auTitle();
    $this->auDescription();
    $this->auKeyword();
    $this->dnsprefetch();
?>

<?php

  }

  function dnsprefetch() {
    echo '
<link rel="dns-prefetch" href="htpp://wtsongs.com" />
<link rel="dns-prefetch" href="http://cdn.wtsongs.com" />
<link rel="dns-prefetch" href="http://static.wtsongs.com" />
<link rel="dns-prefetch" href="http://img.wtsongs.com" />';
  }

  function headmeta() {

?>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php

  }

  function auTitle() {
    echo '
    <title>About Us - wtsongs.com</title>';
  }

  function auDescription() {
    echo '
    <meta name="description" content="About wtsongs.com, wtsongs.com creater, wtsongs.com partners"/>';
  }

  function auKeyword() {
    echo '
    <meta name="keywords" content="wtsongs.com, Manohar kumar at wtsongs.com, pradeep kumar at wtsongs.com, creater of wtsongs.com, wtsongs.com profiles, wtsongs.com website"/>';
  }

  function error_page() {
    $this->headmeta();
    echo '
    <title>404 Not Found</title>';
    $this->dnsprefetch();
  }

  function js_error() {
    $this->headmeta();
    echo '
    <title>you are using an outdated browser.</title>';
    $this->dnsprefetch();
  }
}

?>