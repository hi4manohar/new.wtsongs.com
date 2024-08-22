<?php

include 'M:/xampp/htdocs/sites/ongoing/try.com/getID3-master/getID3-master/getid3/getid3.php';
include 'M:/xampp/htdocs/sites/ongoing/try.com/getID3-master/getID3-master/getid3/write.php';

/*
 *
 * @param filename - Mp3 Url with extension
 * @param icon - Image path to display as cover PNG recommend 
 * @var tag_data - Add Your Mp3 File information | You can create a simple form if you want !!
 *
 */

function change_mp3tag($filename, $icon, &$tag_data) {

    $TextEncoding = 'UTF-8';


// Initialize getID3 engine
    $getID3 = new getID3;
    $getID3->setOption(array('encoding' => $TextEncoding));


// Initialize getID3 tag-writing module
    $tagwriter = new getid3_writetags;
//$tagwriter->filename = '/path/to/file.mp3';
    $tagwriter->filename = $filename;

//$tagwriter->tagformats = array('id3v1', 'id3v2.3');
    $tagwriter->tagformats = array('id3v2.3');

// set various options (optional)
    $tagwriter->overwrite_tags = true;
//$tagwriter->overwrite_tags = false;
    $tagwriter->tag_encoding = $TextEncoding;
    $tagwriter->remove_other_tags = true;

// populate data array
    $fd = fopen($icon, 'rb');
    ob_end_clean();
    $APICdata = fread($fd, filesize($icon));
    fclose($fd);

    $TagData = array(
        'title' => array($tag_data['title']),
        'artist' => array($tag_data['artist']),
        'album' => array($tag_data['album']),
        'year' => array($tag_data['year']),
        'genre' => array($tag_data['genre']),
        'comment' => array($tag_data['comment']),
//enable if you want more tags !!
            //'track' => array('04/16'),
            //'popularimeter' => array('email'=>'user@example.net', 'rating'=>128, 'data'=>0),
    );

    $TagData['attached_picture'][0]['data'] = $APICdata;
    $TagData['attached_picture'][0]['picturetypeid'] = 1;
    $TagData['attached_picture'][0]['description'] = 'icon.png';
    $TagData['attached_picture'][0]['mime'] = 'image/png';

    $tagwriter->tag_data = $TagData;

// write tags
    if ($tagwriter->WriteTags()) {
        echo 'Successfully wrote tags<br>';
        if (!empty($tagwriter->warnings)) {
            echo 'There were some warnings:<br>' . implode('<br><br>', $tagwriter->warnings);
        }
    } else {
        echo 'Failed to write tags!<br>' . implode('<br><br>', $tagwriter->errors);
    }
}

$tag_data = ['title' => 'Test Title', 'artist' => 'Test Artist', 'album' => 'Test Album', 'year' => 2015, 'genre' => 'rock', 'comment' => 'codeniters blog'];

//call change_mp3tag function
change_mp3tag('Love Dose.mp3', 'icon.png', $tag_data);
?>