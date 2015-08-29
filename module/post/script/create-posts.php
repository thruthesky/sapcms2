<?php
$id = "temp-forum";
if ( ! $config = post_config($id) ) {
    $config = post_config()->set('id', $id)->set('name', 'Temp Forum')->save();
}
for ( $i=0; $i<111; $i++ ) {
    $option = [
        'idx_config' => $config->get('idx'),
        'title' => "Title $i",
        'content' => "Content $i",
    ];
    $post = post_data()->newPost($option);
}

$id = "test-forum";
if ( ! $config = post_config($id) ) {
    $config = post_config()->set('id', $id)->set('name', 'This is test forum')->save();
}
for ( $i=0; $i<222; $i++ ) {
    $option = [
        'idx_config' => $config->get('idx'),
        'title' => "Title $i",
        'content' => "Content $i",
    ];
    $post = post_data()->newPost($option);

}
