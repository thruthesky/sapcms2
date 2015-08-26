<?php
$id = "temp-order-list-3";
if ( ! $config = post_config($id) ) {
    $config = post_config()->set('id', $id)->set('name', 'Temp Order List Test 3')->save();
}

// root
$option = [
    'idx_config' => $config->get('idx'),
    'title' => "ROOT",
    'content' => "Content No. 1",
];
$post = post_data()->newPost($option);

echo "root post.idx = " . $post->get('idx') . "\n";


// child 1
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $post->get('idx'),
    'title' => "1",
    'content' => "1",
];
$child1 = post_data()->newPost($option);

// child 2
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $post->get('idx'),
    'title' => "2",
    'content' => "2",
];
$child2 = post_data()->newPost($option);
/*


// child 3
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $post->get('idx'),
    'title' => "3",
    'content' => "3",
];
$child3 = post_data()->newPost($option);
*/
// 2-1
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2->get('idx'),
    'title' => "2-1",
    'content' => "2-1",
];
$child2_1 = post_data()->newPost($option);


$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2_1->get('idx'),
    'title' => "2-1-1",
    'content' => "2-1-1",
];
$child2_1_1 = post_data()->newPost($option);
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2_1->get('idx'),
    'title' => "2-1-2",
    'content' => "2-1-2",
];
$child2_1_2 = post_data()->newPost($option);


$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2_1_1->get('idx'),
    'title' => "2-1-1-1",
    'content' => "2-1-1-1",
];
$child2_1_1 = post_data()->newPost($option);



$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child1->get('idx'),
    'title' => "1-1",
    'content' => "1-1",
];
$child1_1 = post_data()->newPost($option);

/*
// 2-1-1
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2_1->get('idx'),
    'title' => "2-1-1",
    'content' => "2-1-1",
];
$child2_1_1 = post_data()->newPost($option);



// 2-2
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2->get('idx'),
    'title' => "2-2",
    'content' => "2-2",
];
$child2_2 = post_data()->newPost($option);

*/


print_r( post_data()->rows("idx_root=".$post->get('idx')." ORDER BY order_list ASC", 'idx,idx_root,idx_parent,depth,title,order_list') );


// print_r( post_data()->getRecursiveTree($post->get('idx'), "idx, idx_root, idx_parent, title, order_list"));
//print_r( post_data()->getRecursiveTree($child1->get('idx'), "idx, idx_root, idx_parent, title, order_list"));
//print_r( post_data()->getRecursiveTree($child2_1->get('idx'), "idx, idx_root, idx_parent, title, order_list"));

//print_r($posts);

