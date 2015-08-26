<?php
$id = "temp-order-list-2";
if ( ! $config = post_config($id) ) {
    $config = post_config()->set('id', $id)->set('name', 'Temp Order List Test 2')->save();
}

// root
$option = [
    'idx_config' => $config->get('idx'),
    'title' => "PARENT",
    'content' => "Content No. 1",
];
$post = post_data()->newPost($option);

echo "post.idx = " . $post->get('idx') . "\n";


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



// child 3
$option = [ 'idx_config' => $config->get('idx'), 'idx_parent' => $post->get('idx'), 'title' => "3", 'content' => ""];
$child3 = post_data()->newPost($option);


$option = [ 'idx_config' => $config->get('idx'), 'idx_parent' => $post->get('idx'), 'title' => "3-1", 'content' => ""];
$child3_1 = post_data()->newPost($option);
$option = [ 'idx_config' => $config->get('idx'), 'idx_parent' => $post->get('idx'), 'title' => "3-2", 'content' => ""];
$child3_2 = post_data()->newPost($option);
$option = [ 'idx_config' => $config->get('idx'), 'idx_parent' => $post->get('idx'), 'title' => "3-3", 'content' => ""];
$child3_3 = post_data()->newPost($option);


// 2-1
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2->get('idx'),
    'title' => "2-1",
    'content' => "2-1",
];
$child2_1 = post_data()->newPost($option);


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


// 1-1
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child1->get('idx'),
    'title' => "1-1",
    'content' => "",
];
$child1_1 = post_data()->newPost($option);
// 1-2
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child1->get('idx'),
    'title' => "1-2",
    'content' => "",
];
$child1_2 = post_data()->newPost($option);

// 1-1-1
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child1_1->get('idx'),
    'title' => "1-1-1",
    'content' => "",
];
$child1_1_1 = post_data()->newPost($option);





// 2-3
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2->get('idx'),
    'title' => "2-3",
    'content' => "",
];
$child2_3 = post_data()->newPost($option);




// 2-4
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child2->get('idx'),
    'title' => "2-4",
    'content' => "",
];
$child2_4 = post_data()->newPost($option);



// 4
$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $post->get('idx'),
    'title' => "4",
    'content' => "",
];
$child4 = post_data()->newPost($option);

$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child1_2->get('idx'),
    'title' => "1-2-1",
    'content' => "",
];
$child1_2_1 = post_data()->newPost($option);

$option = [
    'idx_config' => $config->get('idx'),
    'idx_parent' => $child1_2->get('idx'),
    'title' => "1-2-2",
    'content' => "",
];
$child1_2_2 = post_data()->newPost($option);





$option = [ 'idx_config' => $config->get('idx'), 'idx_parent' => $child3_2->get('idx'), 'title' => "3-2-1", 'content' => ""];
$child3_2_1 = post_data()->newPost($option);
$option = [ 'idx_config' => $config->get('idx'), 'idx_parent' => $child3_2->get('idx'), 'title' => "3-2-2", 'content' => ""];
$child3_2_2 = post_data()->newPost($option);
$option = [ 'idx_config' => $config->get('idx'), 'idx_parent' => $child3_2->get('idx'), 'title' => "3-2-3", 'content' => ""];
$child3_2_3 = post_data()->newPost($option);
$option = [ 'idx_config' => $config->get('idx'), 'idx_parent' => $child3_2->get('idx'), 'title' => "3-2-4", 'content' => ""];
$child3_2_4 = post_data()->newPost($option);
$option = [ 'idx_config' => $config->get('idx'), 'idx_parent' => $child3_2->get('idx'), 'title' => "3-2-5", 'content' => ""];
$child3_2_5 = post_data()->newPost($option);




$option = [ 'idx_config' => $config->get('idx'), 'idx_parent' => $child3_3->get('idx'), 'title' => "3-3-1", 'content' => ""];
$child3_3_1 = post_data()->newPost($option);






$option = [ 'idx_config' => $config->get('idx'), 'idx_parent' => $child3_2_4->get('idx'), 'title' => "3-2-4-1", 'content' => ""];
$child3_2_4_1 = post_data()->newPost($option);


$option = [ 'idx_config' => $config->get('idx'), 'idx_parent' => $child3_2_2->get('idx'), 'title' => "3-2-2-1", 'content' => ""];
$child3_2_1 = post_data()->newPost($option);





$option = [ 'idx_config' => $config->get('idx'), 'idx_parent' => $child3_1->get('idx'), 'title' => "3-1-1", 'content' => ""];
$child3_1_1 = post_data()->newPost($option);




$posts = post_data()->rows("idx_root=".$post->get('idx')." ORDER BY order_list ASC", 'idx,idx_root,idx_parent,depth,title,order_list');


foreach ( $posts  as $post ) {
    echo str_repeat("    ", $post['depth']);
    echo "$post[title]\n";
}

