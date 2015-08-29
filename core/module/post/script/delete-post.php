<?php
$id = "test-forum-for-delete";
if ( $config = post_config($id) ) $config->delete();
$config = post_config()->set('id', $id)->set('name', $id)->save();
$option = [
    'idx_config' => $config->get('idx'),
    'title' => "No title",
    'content' => "Content 2",
];
$post = post_data()->newPost($option);
print_r( $config->count() );

