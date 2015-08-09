<?php

$argv = $GLOBALS['argv'];

$code = $argv[2];
$content = null;
$no = 20000;
for( $i=0; $i < $no; $i++ ) {
    entity('stress')
        ->set('name', "name-$code $i")
        ->set('subject', "subject-$code $i")
        ->set('content', "content-$code $i - $content")
        ->set('no', $i)
        ->save();
    echo ".";
    if ( $i % 100 == 0 ) echo $i;
}