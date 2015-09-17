<?php
include 'create-posts-with-image.php';
$id = "temp-forum";
if ( ! $config = post_config($id) ) {
    $config = post_config()->set('id', $id)->set('name', 'Temp Forum')->save();
}
for ( $i=0; $i<1500; $i++ ) {
    $option = [
        'idx_config' => $config->get('idx'),
        'title' => "Title $i",
        'content' => "Content $i",
		'created' => time() - 60 * 60 * 24 * rand(0,30)
    ];
    $post = post_data()->newPost($option);
}


$id = "test-freetalk";
if ( ! $config = post_config($id) ) {
    $config = post_config()->set('id', $id)->set('name', 'This is test freetalk forum')->save();
}
for ( $i=0; $i<1500; $i++ ) {
    $option = [
        'idx_config' => $config->get('idx'),
        'title' => "Title $i",
        'content' => "Content $i",
		'created' =>time() - 60 * 60 * 24 * rand(0,30)
    ];
    $post = post_data()->newPost($option);
}


