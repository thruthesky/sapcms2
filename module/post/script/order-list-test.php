<?php
$id = "OrderListTest2";
if ( ! $config = post_config($id) ) {
    $config = post_config()->set('id', $id)->set('name', 'Order List Test 2')->save();
}
$idx_config = $config->get('idx');
$data = post_data()->createRandomPost(['idx_config'=>$idx_config]);
echo $data->get('title') . "\n";
$idx_root = $data->get('idx');
for ( $i = 1; $i < 26; $i ++ ) {
    $title = chr($i + 64);
    $comment = post_data()->createRandomPost(['idx_config'=>$idx_config, 'idx_parent'=>$data->get('idx'), 'title'=>$title]);
}


echo "Total comment of 1st depth: " . post_data()->count("idx_root=$idx_root and idx_parent>0") . PHP_EOL;


for ( $i = 0; $i < 555; $i ++ ) {
    $max = post_data()->countComment($idx_root);
    $rand = rand(1,$max-1);
    $comment = post_data()->query("idx_root=$idx_root AND idx_parent>0 ORDER BY idx ASC LIMIT $rand,1");
    $idx = $comment->idx;
    $title = $comment->title;
    echo "Random idx: $idx, ";
    echo "$title";
    echo "\n";
    $title = "PARENT: $idx, $title";
    $comment = post_data()->createRandomPost(['idx_config'=>$idx_config, 'idx_parent'=>$idx, 'title'=>$title]);
}


// print_r( post_data()->getRecursiveTreeWithSelf($idx_root) );

//$posts = post_data()->getRecursiveTree($idx_root, 'idx, idx_root, depth, idx_parent, order_list, title');

echo "Tree:\n";
$posts = post_data()->getComments($idx_root);
$order_list = [];
foreach( $posts as $post ) {
    echo str_repeat('   ', $post['depth']);
    echo "$post[idx] $post[title] ( $post[order_list] )" . PHP_EOL;

    if ( isset($order_list[$post['order_list']]) ) {
        echo "ERROR. order list duplicated!";
        exit;
    }

    $order_list[$post['order_list']] = true;
}


echo "Run time: " . system_runtime();