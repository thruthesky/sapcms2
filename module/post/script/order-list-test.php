<?php
$id = "temp-order-list-test";
if ( ! $config = post_config($id) ) {
    $config = post_config()->set('id', $id)->set('name', 'Temp Order List Test Random')->save();
}

$idx_config = $config->get('idx');

// root
$option = [
    'idx_config' => $config->get('idx'),
    'title' => "PARENT 1",
    'content' => "Content No. 1",
];
post_data()->newPost($option);

// root
$option = [
    'idx_config' => $config->get('idx'),
    'title' => "PARENT 2",
    'content' => "Content No. 2",
];
$post = post_data()->newPost($option);



$idx_root = $post->get('idx');


