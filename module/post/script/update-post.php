<?php
$id = "form-test-2";
if ( $config = post_config($id) ) $config->delete();
$config = post_config()->set('id', $id)->set('name', 'Temp Forum')->save();


    $option = [
        'idx_config' => $config->get('idx'),
        'title' => "No title",
        'content' => "Content 2",
    ];
    $post = post_data()->newPost($option);

print_r( post_data()->row("idx_config=".$config->get('idx'), "idx,title,content"));

$option = [
    'idx' => $post->idx,
    'title' => "new title !!",
];

$dataUpdated = post_data()->updatePost($option);

print_r( post_data()->row("idx_config=".$config->get('idx'), "idx,title,content"));
