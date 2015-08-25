<?php
$id = "temp-forum";
if ( ! $config = post_config($id) ) {
    $config = post_config()->set('id', $id)->set('name', 'Temp Forum')->save();
}

for ( $i=0; $i<555; $i++ ) {
    $option = [
        'idx_config' => $config->get('idx'),
        'title' => "Title $i",
        'content' => "Content $i",
    ];
    $post = post_data()->newPost($option);

}