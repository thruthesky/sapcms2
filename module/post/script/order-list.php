<?php
$id = "temp-order-list";
if ( ! $config = post_config($id) ) {
    $config = post_config()->set('id', $id)->set('name', 'Temp Order List Test')->save();
}


// root
$option = [
    'idx_config' => $config->get('idx'),
    'title' => "PARENT",
    'content' => "Content No. 1",
];
$post = post_data()->newPost($option);


// child 1
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $post->get('idx'),
    'title' => "Child 1",
    'content' => "Child 1",
];
$child1 = post_data()->newPost($option);


// child 2
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $post->get('idx'),
    'title' => "Child 2",
    'content' => "Child 2",
];
$child2 = post_data()->newPost($option);


// child 3
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $post->get('idx'),
    'title' => "Child 3",
    'content' => "Child 3",
];
$child3 = post_data()->newPost($option);

/*
// child2-1
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2->get('idx'),
    'title' => "Child 2-1",
    'content' => "Child 2-1",
];
$child2_1 = post_data()->newPost($option);
*/