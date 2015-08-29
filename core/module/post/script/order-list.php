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
    'title' => "3",
    'content' => "3",
];
$child3 = post_data()->newPost($option);


// 2-1
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2->get('idx'),
    'title' => "2-1",
    'content' => "2-1",
];
$child2_1 = post_data()->newPost($option);

// 2-2
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2->get('idx'),
    'title' => "2-2",
    'content' => "2-2",
];
$child2_2 = post_data()->newPost($option);



// 2-1-1
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2_1->get('idx'),
    'title' => "2-1-1",
    'content' => "2-1-1",
];
$child2_1_1 = post_data()->newPost($option);


// 2-1-2
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2_1->get('idx'),
    'title' => "2-1-2",
    'content' => "2-1-2",
];
$child2_1_2 = post_data()->newPost($option);


// 2-1-1-1
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2_1_1->get('idx'),
    'title' => "2-1-1-1",
    'content' => "2-1-1-1",
];
$child2_1_1_1 = post_data()->newPost($option);


// 2-1-1-2
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2_1_1->get('idx'),
    'title' => "2-1-1-2",
    'content' => "2-1-1-2",
];
$child2_1_1_2 = post_data()->newPost($option);



// 2-3
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2->get('idx'),
    'title' => "2-3",
    'content' => "2-3",
];
$child3 = post_data()->newPost($option);



// 2-2-1
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2_2->get('idx'),
    'title' => "2-2-1",
    'content' => "2-2-1",
];
$child2_2_1 = post_data()->newPost($option);




$posts = post_data()->rows("idx_root=".$post->get('idx')." ORDER BY order_list ASC", 'idx,idx_root,idx_parent,depth,title,order_list');
print_r($posts);

