<?php

class seo {

  public $pTitle;
  public $pImage;
  public $alTitle;
  public $pTitleLetter;
  public $curUrl;
  public $alTitleLetter;
  public $alImage;
  public $alLang;
  public $arTitle;
  public $arImage;
  public $arArray;
  public $arFletter;

  function global_generic() {
    global $generic;
    return $generic;
  }

  public function displayHeadSeo() {
    $this->heademeta();
    $this->displayTitle();
    $this->displayDescription();
    $this->displayKeyword();
    $this->dnsprefetch();
    $this->twitterContent();
    $this->fbContent();
  }

  public function playlistSeo($playlistTitle) {
    $this->heademeta();
    $this->pTitle = $playlistTitle;
    $this->pTitleLetter = substr($playlistTitle, 0, 1);
    $this->pImage = str_replace(' ', '+', $this->pTitle);
    $this->plTitle();
    $this->plDescription();
    $this->plKeyword();
    $this->dnsprefetch();
    $this->pltwitterContent();
    $this->plFbContent();
  }

  public function fplaylistSeo() {
    $this->heademeta();
    $this->fpTitle();
    $this->fpDescription();
    $this->fpKeyword();
    $this->dnsprefetch();
    $this->fpTwitterContent();
    $this->fpFbContent();
  }

  public function albumSeo($albumName) {
    $this->generic = $this->global_generic();
    $this->meta_image = $this->generic->get_images( "album", $albumName, "_175x175" );
    $this->alTitle = $albumName;
    $this->alTitleLetter = substr($albumName, 0, 1);
    $this->alImage = str_replace(' ', '+', $albumName);
    $this->alTitle();
    $this->alDescription();
    $this->alKeyword();
    $this->dnsprefetch();
    $this->alTwitterContent();
    $this->alFbContent();
  }

  public function albumSongSeo() {
    $this->alTitle = alTitle;
    $this->alSongTitle = alHeadTitle;
    $this->alTitleLetter = substr(alTitle, 0, 1);
    $this->alImage = str_replace(' ', '+', alTitle);
    $this->alSongTitle();
    $this->alSongDescription();
    $this->alSongKeyword();
    $this->dnsprefetch();
    $this->alSongTwitterContent();
    $this->alSongFbContent();
  }

  public function popularCategorySeo() {
    $this->heademeta();
    $this->dnsprefetch();
    if( defined('catExist') && catExist !== "" ) {
      $this->ceTitle();
      $this->ceDescription();
      $this->ceKeyword();
      $this->ceTwitterContent();
      $this->ceFbContent();
    } else {
      $this->pcTitle();
      $this->pcDescription();
      $this->pcKeyword();
      $this->pcTwitterContent();
      $this->pcFbContent();
    }
    
  }

  public function albumsSeo($lang, $category) {
    $this->heademeta();
    $this->alCategory = $category;
    $this->alLang = $lang;
    $this->asTitle();
    $this->asDescription();
    $this->asKeyword();
    $this->dnsprefetch();
    $this->asTwitterContent();
    $this->asFbContent();
  }

  public function artistSeo($artist, $cat, $start, $limit) {
    $this->arFletter = substr($artist, 0, 1);
    $this->arTitle = $artist;
    $this->arImage = str_replace(' ', '+', $artist);
    $this->heademeta();
    $this->arTitle();
    $this->arDescription();
    $this->arKeyword();
    $this->dnsprefetch();
    $this->arTwitterContent();
    $this->arFbContent();
    if( $cat == "overview" || $cat == "songs" ) {
      list( $oData ) = $this->arOverviewedSong($start, $limit);
      $this->arSongMeta($oData);
      return $oData;
    } elseif( $cat == "albums" ) return array('artist_img' => "http://img.wtsongs.com/images/artists/$this->arFletter/" . $this->arImage . "_175x175.jpg" );
  }

  public function top_charts() {
    $this->heademeta();
    $this->tcTitle();
    $this->tcDescription();
    $this->tcKeyword();
    $this->dnsprefetch();
    $this->tcTwitterContent();
    $this->tcFbContent();
  }

  function searchSeo() {
    $this->heademeta();
    $this->ssTitle();
    $this->ssDescription();
    $this->ssKeyword();
    $this->dnsprefetch();
    $this->ssTwitterContent();
    $this->ssFbContent();
  }

  public function headerCommonStyles() {
    $this->commonStyle();
  }

  public function __construct() {
    $this->curUrl= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $lastPathName = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    $this->plName = str_replace('.php', '', $lastPathName);
    $this->headerCommonStyles();
    $this->headerCommonScript();
  }

  function arOverviewedSong($start, $limit) {
    $arSongSql = "SELECT t.track_id, t.track_title, t.artist_name, t.play_hits, al.album_title, al.album_id, l.lang_title FROM wt_tracks as t, wt_albums as al, wt_lang as l WHERE artist_name LIKE '%" . mysqli_escape_string($GLOBALS['link'], $this->arTitle) . "%' AND t.album_id=al.album_id AND al.lang_id=l.lang_id ORDER BY play_hits DESC LIMIT $start, $limit";
    $arResult = mysqli_query( $GLOBALS['link'], $arSongSql );
    if( mysqli_num_rows( $arResult ) > 0 ) {
      while ( $arRow = mysqli_fetch_assoc($arResult) ) {
        $ar['track_id'][] = $arRow['track_id'];
        $ar['track_title'][] = $arRow['track_title'];
        $ar['artist_name'][] = $arRow['artist_name'];
        $ar['album_title'][] = $arRow['album_title'];
        $ar['album_id'][] = $arRow['album_id'];
        $ar['track_playhits'][] = $arRow['play_hits'];
        $ar['lang_title'][] = $arRow['lang_title'];
        if( is_numeric( substr($arRow['album_title'], -4) ) ) {
          $ar['album_name_without_year'][] = substr($arRow['album_title'], 0, -5);
        } else $ar['album_name_without_year'][] = $arRow['album_title'];
      }

      $arTotalTrack = mysqli_query( $GLOBALS['link'], "SELECT * FROM wt_tracks WHERE artist_name LIKE '%" . mysqli_escape_string($GLOBALS['link'], $this->arTitle) . "%'" );
      $ar['total_track'] = mysqli_num_rows( $arTotalTrack );
      $ar['t_title'] = str_replace(' ', '+', $ar['track_title']);
      $ar['track_title_url'] = array_map('strtolower', $ar['t_title']);
      $ar['a_title'] = str_replace(' ', '+', $ar['album_title']);
      $ar['album_title_url'] = array_map('strtolower', $ar['a_title']);
      $ar['ar_img'] = "http://img.wtsongs.com/images/artists/$this->arFletter/" . $this->arImage . "_175x175.jpg";
      if(!@getimagesize($ar['ar_img'])) {
        $ar['artist_img'] = "http://img.wtsongs.com/images/static/song_default_175x175.jpg";
      } else $ar['artist_img'] = $ar['ar_img'];
      unset( $ar['t_title'], $ar['a_title'], $ar['ar_img'] );
      return array( $ar );
    } else {
      goto_errorpage();
    }
  }
  
  function commonStyle() {
  }

  function headerCommonScript() {

?>

<script type="text/javascript">
  var baseUrl="<?php echo baseUrl ?>"; var imgUrl="http://img.wtsongs.com"; var cdnUrl="http://cdn.wtsongs.com"; var GlobalLangArr="Hindi,English,Tamil,Bengali,Bhojpuri,Telugu,Punjabi,Others";var phpCurUrl="<?php echo $this->curUrl; ?>";
  if (screen.width <= 800) {
    window.location = "http://m.wtsongs.com";
  }
</script>

<?php

  }

  function heademeta() {

?>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<noscript><meta http-equiv="refresh" content="0; URL=/bad_browser"></noscript>

<?php

  }

  function ssTitle() {
    echo '
    <title>Search albums, songs, playlists, artists, movies at wtsongs.com</title>';
  }

  function ssDescription() {
    echo '
    <meta name="description" content="Browse and Search languages, movies, albums, popular songs, popular atists, popular playlists at wtsongs.com"/>';
  }

  function ssKeyword() {
    echo '
    <meta name="keywords" content="search albums, search songs, search playlists, search artists, free movies albums free bollywood albums"/>';
  }

  function ssTwitterContent() {
    echo '
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:url" content=""/>
    <meta name="twitter:site" content="@wtsongs"/>
    <meta name="twitter:title" content="Search all type of movie albums, artists, songs, playlists at wtsongs.com"/>
    <meta name="twitter:image" content="http://img.wtsongs.com/static/social/wt-social.jpg"/>';
  }

  function ssFbContent() {
    echo '
    <meta property="fb:app_id" content="515979721894250"/>
    <meta property="og:site_name" content="wtsongs.com"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content=""/>
    <meta property="og:title" content="LSearch all type of movie albums, artists, songs, playlists at wtsongs.com"/>
    <meta property="og:description" content="Search Music, Albums, Playlists, Artists, Languages, Most Popular Songs at wtsongs.com"/>
    <meta property="og:image" content="http://img.wtsongs.com/static/social/wt-social.jpg"/>';
  }

  function tcTitle() {
    echo '
    <title>Browse Top Collection of Music - wtsongs.com</title>';
  }

  function tcDescription() {
    echo '
    <meta name="description" content="Free Listen and Download Top Bollwood Mp3 Song, Hindi Music, Bangali Music. Make Your Own Favourite Top Playlist Including all Languages at wtsongs.com" />';
  }

  function tcKeyword() {
    echo '
    <meta name="keywords" content="Bollywood Top Song, Hindi Top Song, Top Mp3 Song Download, Free Best Music, Free Songs, Make Top Playlist, Free Top Playlist, Top Albums, Best English Music Album, Best Bhojpuri Top Song, Weekely Top Music, This Month Top Song, Top Song Collection, Top Mp3 Song Collection" />';
  }

  function tcTwitterContent() {
    echo '
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:url" content="http://www.wtsongs.com/top-charts.php"/>
    <meta name="twitter:site" content="@wtsongs"/>
    <meta name="twitter:title" content="Listen Download and Create Your Top Music Collection at wtsongs.com"/>
    <meta name="twitter:image" content="http://img.wtsongs.com/static/social/wt-social.jpg"/>';
  }

  function tcFbContent() {
    echo '
    <meta property="fb:app_id" content="515979721894250"/>
    <meta property="og:site_name" content="wtsongs.com"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="http://www.wtsongs.com/top-charts.php"/>
    <meta property="og:title" content="Listen Download and Create Your Top Music Collection - wtsongs.com "/>
    <meta property="og:description" content="Free Listen and Download Top Collection of Music including Bollywood Hindi English at wtsongs.com"/>
    <meta property="og:image" content="http://img.wtsongs.com/static/social/wt-social.jpg"/>';
  }

  function arSongMeta($oSongData) {
    foreach( $oSongData['track_title_url'] as $value ) {
      echo '
      <meta property="music:song" content="http://www.wtsongs.com/song/' . $value . '"/>';
    }
  }

  function arTitle() {
    echo '<title>Browse and Download Complete and Popular ' . $this->arTitle . ' Albums, Mp3 Songs for Free at wtsongs.com</title>';
  }

  function arDescription() {
    echo '
<meta name="description" content="Free Listen and Download Complete list of Popular ' . $this->arTitle . ' Albums, Bollywood Album Mp3 Song, ' . $this->arTitle . ' Mp3 Song, ' . $this->arTitle . ' hindi songs at wtsongs.com"/>';
  }

  function arKeyword() {
    echo "
<meta name=\"keywords\" content=\"$this->arTitle mp3 songs, $this->arTitle albums, $this->arTitle playlists, $this->arTitle popular albums songs, free download $this->arTitle mp3 songs\" />";
  }

  function arTwitterContent() {
    echo '
<meta name="twitter:card" content="summary"/>
<meta name="twitter:url" content="' . $this->curUrl . '"/>
<meta name="twitter:site" content="@wtsongs"/>
<meta name="twitter:title" content="Browse and Download Popular ' . $this->arTitle . ' Album Mp3 Song at wtsongs.com"/>
<meta name="twitter:description" content="Free Listen, Download and Browse Popular Albums of ' . $this->arTitle . ' at wtsongs.com"/>
<meta name="twitter:image" content="http://img.wtsongs.com/artists/' . $this->arFletter . '/' . $this->arImage . '_175x175.jpg"/>';
  }

  function arFbContent() {
    echo '
<meta property="fb:app_id" content="515979721894250"/>
<meta property="og:site_name" content="wtsongs.com"/>
<meta property="og:type" content="music.category"/>
<meta property="og:url" content="' . $this->curUrl . '"/>
<meta property="og:title" content="Browse and Download Popular ' . $this->arTitle . ' Album Mp3 Song at wtsongs.com"/>
<meta property="og:description" content="Free Listen, Download and Browse Popular Albums of ' . $this->arTitle . ' at wtsongs.com"/>
<meta property="og:image" content="http://img.wtsongs.com/artists/' . $this->arFletter . '/' . $this->arImage . '_175x175.jpg"/>';
  }

  function asTitle() {
    echo '<title>Browse and Download Complete Popular ' . $this->alLang . ' ' . $this->alCategory . ' Mp3 Song for Free at wtsongs.com</title>';
  }

  function asDescription() {
    echo '
<meta name="description" content="Free Listen and Download Complete list of Popular ' . $this->alLang . ' ' . $this->alCategory . ', ' . $this->alCategory . ' Mp3 Songs playlists, at wtsongs.com"/>';
  }

  function asKeyword() {
    echo '
<meta name="keywords" content="Popular ' . $this->alLang . ' ' . $this->alCategory . ', ' . $this->alLang . ' ' . $this->alCategory . ' MP3 Song, Free Download ' . $this->alCategory . ' Mp3 Song, ' . $this->alLang . ' Movie Song, ' . $this->alLang . ' Mp3 Song, Free Download Full ' . $this->alLang . ',  ' . $this->alCategory . ' Tamil ' . $this->alCategory . ' Mp3 Song, Bangali ' . $this->alCategory . ' Mp3 Song, Free Download ' . $this->alCategory . ' Movie Mp3 Song." />';
  }

  function asTwitterContent() {
    echo '
<meta name="twitter:card" content="summary"/>
<meta name="twitter:url" content="' . $this->curUrl . '"/>
<meta name="twitter:site" content="@wtsongs"/>
<meta name="twitter:title" content="Browse and Download Popular ' . $this->alCategory . ' Mp3 Song at wtsongs.com"/>
<meta name="twitter:description" content="Free Listen, Download and Browse Popular ' . $this->alCategory . ', ' . $this->alLang . ' Mp3 Song, ' . $this->alLang . ' Mp3 Song at wtsongs.com"/>
<meta name="twitter:image" content="http://img.wtsongs.com/static/social/wt-social.jpg"/>';
  }

  function asFbContent() {
    echo '
<meta property="fb:app_id" content="515979721894250"/>
<meta property="og:site_name" content="wtsongs.com"/>
<meta property="og:type" content="music.category"/>
<meta property="og:url" content="' . $this->curUrl . '"/>
<meta property="og:title" content="Browse and Download Popular ' . $this->alCategory . ' Mp3 Song at wtsongs.com"/>
<meta property="og:description" content="Free Listen, Download and Browse Popular ' . $this->alCategory . ', ' . $this->alLang . ' Mp3 Song, ' . $this->alLang . ' Mp3 Song at wtsongs.com"/>
<meta property="og:image" content="http://img.wtsongs.com/static/social/wt-social.jpg"/>';
  }

  function ceTitle() {
    echo '
<title>Access all type of popular ' . catExist . ' playlists, albums, Genres at wtsongs.com</title>';
  }

  function ceDescription() {
    echo '
<meta name="description" content="Browse, listen and download bollywood ' . catExist . ', songs playlists for free at wtsongs.com"/>';
  }

  function ceKeyword() {
    echo '
<meta name="keywords" content="' . catExist . ' playlists, free download ' . catExist . ' mp3 songs, ' . catExist . ' free music ' . catExist . ' bollywood music at wtsongs.com" />';
  }

  function ceTwitterContent() {
    echo '
<meta name="twitter:card" content="summary"/>
<meta name="twitter:url" content="' . $this->curUrl . '"/>
<meta name="twitter:site" content="@wtsongs"/>
<meta name="twitter:title" content="Popular ' . catExist . ' playlists at wtsongs.com"/>
<meta name="twitter:description" content="Free listen and download complete playlists of ' . catExist . ' at wtsongs.com"/>
<meta name="twitter:image" content="http://img.wtsongs.com/static/social/wt-social.jpg"/>';
  }

  function ceFbContent() {
    echo '
<meta property="fb:app_id" content="515979721894250"/>
<meta property="og:site_name" content="wtsongs.com"/>
<meta property="og:type" content="music.category"/>
<meta property="og:url" content="' . $this->curUrl . '"/>
<meta property="og:title" content="Popular ' . catExist . ' playlists at wtsongs.com"/>
<meta property="og:description" content="Free listen and download complete playlists of ' . catExist . ' at wtsongs.com"/>
<meta property="og:image" content="http://img.wtsongs.com/static/social/wt-social.jpg"/>';
  }

  function pcTitle() {
    echo '
<title>Party, Pop, Bollywood, devotional, chill, kids, ghazal, festival music at wtsongs.com</title>';
  }

  function pcDescription() {
    echo '
<meta name="description" content="Free Listen, Browse and Download romance, kids, party, devotional, fetival, hot music at wtsongs.com"/>';
  }

  function pcKeyword() {
    echo '
<meta name="keywords" content="Genre Music, Pop Mp3 Song, Top Kids Song, Wedding Song, Chill Song, Rock Song, Popular Moods Song, Workout Song, Hip Hop Song, Free Download Mp3 Song, Free Listen Mp3 Song, Free Download Top Song" />';
  }

  function pcTwitterContent() {
    echo '
<meta name="twitter:card" content="summary"/>
<meta name="twitter:url" content="' . $this->curUrl . '"/>
<meta name="twitter:site" content="@wtsongs"/>
<meta name="twitter:title" content="Popular Genres, Kids, Festival, Wedding Song at wtsongs.com"/>
<meta name="twitter:description" content="Browse and Download Most Popular Category Music Mp3 Song at wtsongs.com"/>
<meta name="twitter:image" content="http://img.wtsongs.com/static/social/wt-social.jpg"/>';
  }

  function pcFbContent() {
    echo '
<meta property="fb:app_id" content="515979721894250"/>
<meta property="og:site_name" content="wtsongs.com"/>
<meta property="og:type" content="music.category"/>
<meta property="og:url" content="' . $this->curUrl . '"/>
<meta property="og:title" content="Popular Genres, Kids, Festival, Wedding Song at wtsongs.com"/>
<meta property="og:description" content="Browse and Download Most Popular Category Music Mp3 Song at wtsongs.com"/>
<meta property="og:image" content="http://img.wtsongs.com/static/social/wt-social.jpg"/>';
  }

  function alSongTitle() {
    echo '<title>Online Listen and Download ' . $this->alSongTitle . ' song from album ' . $this->alTitle . ' and it\'s all Mp3 Songs at wtsongs.com</title>';
  }

  function alSongDescription() {
    echo '
<meta name="description" content="Online Listen and Download ' . $this->alSongTitle . ' Mp3 Song from album ' . $this->alTitle . ' at wtsongs.com, ' . $this->alTitle . ' album is available now free offline at wtsongs.com "/>';
  }

  function alSongKeyword() {
    echo '
<meta name="keywords" content="free downnload ' . $this->alTitle . ' album mp3 song, ' . $this->alSongTitle . ' song, Online Listen ' . $this->alSongTitle . ' song offline, ' . $this->alSongTitle . ' mp3 song, ' . $this->alTitle . ' album song, free listen ' . $this->alTitle . ' full mp3 song, Free download all mp3 song of ' . $this->alTitle . ' album " />';
  }

  function alSongTwitterContent() {
    echo '
<meta name="twitter:card" content="summary"/>
<meta name="twitter:url" content="' . $this->curUrl . '"/>
<meta name="twitter:site" content="@wtsongs"/>
<meta name="twitter:title" content="Online Listen and Download ' . $this->alSongTitle . ' Song from album ' . $this->alTitle . ' at wtsongs.com"/>
<meta name="twitter:description" content="Listen and Download Completely free song ' . $this->alSongTitle . ' Song from album ' . $this->alTitle . ' at wtsongs.com"/>
<meta name="twitter:image" content="http://img.wtsongs.com/images/albums/' . $this->alTitleLetter . "/" . $this->alTitle . '/' . $this->alImage . '_175x175.jpg"/>';
  }

  function alSongFbContent() {
    echo '
<meta property="fb:app_id" content="515979721894250"/>
<meta property="og:site_name" content="wtsongs.com"/>
<meta property="og:type" content="music.album"/>
<meta property="og:url" content="' . $this->curUrl . '"/>
<meta property="og:title" content="Online Listen and Download ' . $this->alSongTitle . ' Song from album ' . $this->alTitle . ' at wtsongs.com"/>
<meta property="og:description" content="Listen and Download Completely free song ' . $this->alSongTitle . ' Song from album ' . $this->alTitle . ' at wtsongs.com"/>
<meta property="og:image" content="http://img.wtsongs.com/images/albums/' . $this->alTitleLetter . "/" . $this->alTitle . '/' . $this->alImage . '_175x175.jpg"/>
<meta property="og:audio" content="http://www.wtsongs.com/albums/' . $this->alImage . '"/>
';
  }

  function alTitle() {
    echo '<title>Free Listen and Download ' . $this->alTitle . ' album Mp3 Songs at wtsongs.com</title>';
  }

  function alDescription() {
    echo '
<meta name="description" content="Free Listen and Download all Mp3 Song of ' . $this->alTitle . ' Album at wtsongs.com, ' . $this->alTitle . ' album is available now free offline at wtsongs.com "/>
';
  }

  function alKeyword() {
    echo '
<meta name="keywords" content="free downnload ' . $this->alTitle . ' mp3 song, ' . $this->alTitle . ' album, ' . $this->alTitle . ' offline song, ' . $this->alTitle . ' mp3 song, ' . $this->alTitle . ' album song, free listen ' . $this->alTitle . ' full mp3 song" />';
  }

  function alTwitterContent() {
    echo '
<meta name="twitter:card" content="summary"/>
<meta name="twitter:url" content="' . $this->curUrl . '"/>
<meta name="twitter:site" content="@wtsongs"/>
<meta name="twitter:title" content="Listen ' . $this->alTitle . ' Album at wtsongs.com"/>
<meta name="twitter:description" content="Listen and Download Complete Free ' . $this->alTitle . ' album Mp3 Song at wtsongs.com"/>
<meta name="twitter:image" content="' . $this->meta_image . '"/>';
  }

  function alFbContent() {
    echo '
<meta property="fb:app_id" content="515979721894250"/>
<meta property="og:site_name" content="wtsongs.com"/>
<meta property="og:type" content="music.album"/>
<meta property="og:url" content="http://www.wtsongs.com"/>
<meta property="og:title" content="' . $this->alTitle . ' Album Mp3 Song at wtsongs.com"/>
<meta property="og:description" content="Listen and Download Free ' . $this->alTitle . ' Album Mp3 Song at wtsongs.com"/>
<meta property="og:image" content="' . $this->meta_image . '"/>
<meta property="og:audio" content="http://www.wtsongs.com/albums/' . $this->alImage . '"/>
';
  }

  function alSongMeta() {
    $meta_track_data = "SELECT wt.track_title 
FROM wt_tracks as wt, wt_albums as al 
WHERE al.album_title = '" . alTitle . "' 
AND al.album_id = wt.album_id";
    $meta_track_result = mysqli_query( $GLOBALS['link'], $meta_track_data );

    if( mysqli_num_rows( $meta_track_result ) > 0 ) {
      while($meta_track_row = mysqli_fetch_assoc( $meta_track_result )) {
        $meta_track_title[] = $meta_track_row['track_title'];
      }
      $meta_track_url = str_replace(' ', '+', $meta_track_title);
      $meta_track_url = array_map( 'strtolower', $meta_track_url );
      foreach ($meta_track_url as $key => $value) {
        echo '<meta property="music:song" content="http://www.wtsongs.com/song/' . $meta_track_url[$key] . '"/>
      ';
      }
    } else {
      $error = "not-exist";
      return $error;
    }
  }

  public function displayTitle() {
    echo "<title>Free Listen and Download Unlimited Song - wtsongs.com</title>\n";
  }

  public function displayDescription() {
    echo '
<meta name="description" content="Download and Listen Free Music including Hindi, Bollywood, English, Bhojuri, Tamil, Telugu Albums Playlist at wtsongs.com" />';
  }

  public function displayKeyword() {
    echo '
<meta name="keywords" content="bollywood latest songs, bollywood latest albums, bollywood new albums, bollywood new mp3 songs,bollywood songs, new songs, new mp3 songs, latest albums, latest songs, a-z bollywood movies songs,a-z movies songs, lates bollywood movies song free download, hindi movies songs,naya bollywood songs,all language albums, bollywood instrumental, bollywood new songs instrumental, latest instrumenta, devotional songs, latest devotional songs, a-z artist songs, all artist songs, indian pop songs, bollywood singles songs, bollywood remix songs, bollywood devotional songs, gazalsbhojpuri latest songs, bhojpuri latest albums, bhojpuri new albums, bhojpuri new mp3 songs,bhojpuri songs, new songs, new mp3 songs, latest albums, latest songs, a-z bhojpuri movies songs,bhojpuri a-z movies songs, lates bhojpuri movies song free download, bhojpuri movies songs, naya bhojpuri songs, bhojpuri remix songs, bhojpuri devotional songs,tamil latest songs, tamil latest albums, tamil new albums, tamil new mp3 songs,tamil songs, new songs, new mp3 songs,latest albums, latest songs, a-z tamil movies songs,tamil a-z movies songs, lates tamil movies song free download, tamil movies songs, naya tamil songs,tamil remix songs, tamil devotional songs,telugu latest songs, telugu latest albums, telugu new albums, telugu new mp3 songs,telugu songs, new songs, new mp3 songs, latest albums, latest songs, a-z telugu movies songs,telugu a-z movies songs, lates telugu movies song free download, telugu movies songs, naya telugu songs, telugu remix songs, telugu devotional songs,bangali latest songs, bangali latest albums, bangali new albums, bangali new mp3 songs,bangali songs, new songs, new mp3 songs, latest albums, latest songs, a-z bangali movies songs,bangali a-z movies songs, lates bangali movies song free download, bangali movies songs, naya bangali songs, bangali remix songs, bangali devotional songs,gujrati latest songs, gujrati latest albums, gujrati new albums, gujrati new mp3 songs,gujrati songs, new songs, new mp3 songs, latest albums, latest songs, a-z gujrati movies songs,gujrati a-z movies songs, lates gujrati movies song free download, gujrati movies songs, naya gujrati songs, gujrati remix songs, gujrati devotional songs,punjabi latest songs, punjabi latest albums, punjabi new albums, punjabi new mp3 songs,punjabi songs, new songs, new mp3 songs, latest albums, latest songs, a-z punjabi movies songs,punjabi a-z movies songs, lates punjabi movies song free download, punjabi movies songs, naya punjabi songs, punjabi singles, punjabi latest singles, punjabi remix songs, punjabi devotional songs,marathi latest songs, marathi latest albums, marathi new albums, marathi new mp3 songs,marathi songs, new songs, new mp3 songs, latest albums, latest songs, a-z marathi movies songs,marathi a-z movies songs, lates marathi movies song free download, marathi movies songs, naya marathi songs, marathi singles, marathi latest singles, marathi remix songs, marathi devotional songs,maithili latest songs, maithili latest albums, maithili new albums, maithili new mp3 songs,maithili songs, new songs, new mp3 songs, latest albums, latest songs, a-z maithili movies songs,maithili a-z movies songs, lates maithili movies song free download, maithili movies songs, naya maithili songs, maithili singles, maithili latest singles, maithili remix songs, maithili devotional songs, maithili vivah geet," />';
  }

  public function dnsprefetch() {
    echo '
<link rel="dns-prefetch" href="http://wtsongs.com" />
<link rel="dns-prefetch" href="http://cdn.wtsongs.com" />
<link rel="dns-prefetch" href="http://static.wtsongs.com" />
<link rel="dns-prefetch" href="http://img.wtsongs.com" />';
  }

  public function twitterContent() {
    echo '
<meta name="twitter:card" content="summary"/>
<meta name="twitter:url" content="http://www.wtsongs.com"/>
<meta name="twitter:site" content="@wtsongs"/>
<meta name="twitter:title" content="Download and Listen Free Music - wtsongs.com"/>
<meta name="twitter:description" content="Free Music Listining and Download including Playlists Albums Top Categories. Share and Make Your Favorites music - wtsongs.com"/>
<meta name="twitter:image" content="http://img.wtsongs.com/static/social/wt-social.jpg"/>';
//meta name="twitter:app:country" content="IN"
  }

  public function fbContent() {
    echo '
<meta property="fb:app_id" content="515979721894250"/>
<meta property="og:site_name" content="wtsongs.com"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="http://www.wtsongs.com"/>
<meta property="og:title" content="Listen and Download Free Music - wtsongs.com "/>
<meta property="og:description" content="Free Download All Type of Music Including Bollywood, Hindi, English, Bhojpuri, Telugu, Bangali Albums and Playlists."/>
<meta property="og:image" content="http://img.wtsongs.com/static/social/wt-social.jpg"/>';
  }

  function defaultLoader() {
    echo '
    <div id="loader-wrapper">
      <div id="loader"></div>
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
      <header class="entry-header" id="entry-header">
        <div class="loader-image">
          <img src="assets/img/loaderImg2.png" />
        </div>
      </header>
    </div>';
  }

  function plTitle() {
    echo '<title>Listen and Download ' . $this->pTitle . ' Playlist Created By wtsongs at wtsongs.com</title>';
  }

  function plDescription() {
    echo '
<meta name="description" content="Free Listen and Download ' . $this->pTitle . ' Playlist at wtsongs.com Created By wtsongs.com and Make it Your Favourite Playlist "/>';
  }

  function plKeyword() {
    echo '
<meta name="keywords" content="' . $this->pTitle . 'Playlist, Free Download ' . $this->pTitle . 'Playlist, Created By wtsongs, Recently Created ' . $this->pTitle . ' Playlist at wtsongs.com" />';
  }

  function pltwitterContent() {

    echo '
<meta name="twitter:card" content="summary"/>
<meta name="twitter:url" content="' . $this->curUrl . '"/>
<meta name="twitter:site" content="@wtsongs"/>
<meta name="twitter:title" content="Listen ' . $this->pTitle . ' Playlist, Created By wtsongs.com at wtsongs.com"/>
<meta name="twitter:description" content="Listen and Download Free ' . $this->pTitle . ' Playlist Created By wtsongs.com at wtsongs.com"/>
<meta name="twitter:image" content="http://img.wtsongs.com/images/playlists/' . $this->pTitleLetter . "/" . $this->pTitle . '/' . $this->pImage . '_175x175.jpg"/>';
  }

  function plFbContent() {
    echo '
<meta property="fb:app_id" content="515979721894250"/>
<meta property="og:site_name" content="wtsongs.com"/>
<meta property="og:type" content="music.playlist"/>
<meta property="og:url" content="http://www.wtsongs.com"/>
<meta property="og:title" content="Playlist ' . $this->pTitle . ' at wtsongs.com"/>
<meta property="og:description" content="Listen and Download Free ' . $this->pTitle . ' Playlist Created By wtsongs.com at wtsongs.com"/>
<meta property="og:image" content="http://img.wtsongs.com/images/playlists/' . $this->pTitleLetter . "/" . $this->pTitle . '/' . $this->pImage . '_175x175.jpg"/>
<meta property="og:audio" content="http://www.wtsongs.com/playlists/' . $this->pImage . '"/>
';
  }

  public function plSongMeta($top) {

    global $playlist;

    function genreate_meta_track() {
      if( defined( 'activeEditDeletePl' ) && activeEditDeletePl === true ):
        $meta_track_data = "SELECT wt.track_title FROM wt_playlists as pl, wt_playlist_data as pd, wt_tracks as wt, wt_albums as al WHERE pl.playlist_title='" . plTitle . "' AND pd.playlist_id=pl.playlist_id AND wt.track_id=pd.track_id AND al.album_id=wt.album_id AND pl.user_id='" . user_id . "'";
      else:
        $meta_track_data = "SELECT wt.track_title FROM wt_playlists as pl, wt_playlist_data as pd, wt_tracks as wt, wt_albums as al WHERE pl.playlist_title='" . plTitle . "' AND pd.playlist_id=pl.playlist_id AND wt.track_id=pd.track_id AND al.album_id=wt.album_id";
      endif;
      $meta_track_result = mysqli_query( $GLOBALS['link'], $meta_track_data );

      if( mysqli_num_rows( $meta_track_result ) > 0 ) {
        while($meta_track_row = mysqli_fetch_assoc( $meta_track_result )) {
          $meta_track_title[] = $meta_track_row['track_title'];      
        }
        $meta_track_url = array_map( 'strtolower', str_replace(' ', '+', $meta_track_title) );
        foreach ($meta_track_url as $key => $value) {
          echo '<meta property="music:song" content="http://www.wtsongs.com/song/' . $meta_track_url[$key] . '"/>
        ';
        }
        return true;
      } else {
        return true;
      }
    }

    if( $playlist['show_header'] === true ) {
      if( genreate_meta_track() ) {
        return true;
      } else return false;
    }
    
  }

  function fpTitle() {
    echo '<title>Hindi, Bollywood, English Music Playlists By wtsongs.com</title>';
  }

  function fpDescription() {
    echo '
<meta name="description" content="Free Playlists Created By wtsongs.com , listen and download it free on wtsongs.com, create your own playlist and make your Favourite playlist at wtsongs.com" />';
  }

  function fpKeyword() {
    echo '
<meta name="keywords" content="create playlist, music playlist, actor playlist, actor playlist, artist playlist, most popular playlist, create music playlist, make Favourite playlist, create song in favourite playlist, hindi playlist, bhojpuri playlist, maithili playlist, bollywood playlist, at wtsongs.com" />';
  }

  function fpTwitterContent() {
    echo '
<meta name="twitter:card" content="summary"/>
<meta name="twitter:url" content="' . $this->curUrl . '"/>
<meta name="twitter:site" content="@wtsongs"/>
<meta name="twitter:title" content="Listen and Create Your Favorites Playlist at wtsongs.com"/>
<meta name="twitter:description" content="Listen and make your favourite playlist at wtsongs.com with including popular, bollywood, hindi, music playlists."/>
<meta name="twitter:image" content="http://img.wtsongs.com/static/social/wt-social.jpg"/>';
//meta name="twitter:app:country" content="IN"
  }

  function fpFbContent() {
    echo '
<meta property="fb:app_id" content="515979721894250"/>
<meta property="og:site_name" content="wtsongs.com"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="' . $this->curUrl . '"/>
<meta property="og:title" content="Create and Make Your own Favourite Playlist at wtsongs.com"/>
<meta property="og:description" content="Listen and make your favourite playlist at wtsongs.com with including popular, bollywood, hindi, music playlists."/>
<meta property="og:image" content="http://img.wtsongs.com/static/social/wt-social.jpg"/>';
  }

}
?>