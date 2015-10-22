<?php

$id = "wooreeedu";
if ( ! $config = post_config($id) ) {
    $config = post_config()->set('id', $id)->set('name', 'Woreeedu')->save();
}

for( $i = 1; $i<=3; $i ++ ){
	$option = [
		'idx_config' => $config->get('idx'),
		'title' => "Welcome to wooreeedu christmas event! $i",
		'content' => "Wooreeedu post content $i just some added text here to try and find out if it still looks okay even when the content text is long...",
	];
	$post = post_data()->newPost($option);
	$data = $post->attachFile("theme/wooreeedu/img/xmas_$i.jpg");
}

for( $i = 1; $i<=6; $i ++ ){
	$option = [
		'idx_config' => $config->get('idx'),
		'title' => "Welcome to wooreeedu popsong event! $i",
		'content' => "Wooreeedu post content $i just some added text here to try and find out if it still looks okay even when the content text is long...",
	];
	$post = post_data()->newPost($option);
	$data = $post->attachFile("theme/wooreeedu/img/popsong_$i.jpg");
}

for( $i = 10; $i<=13; $i ++ ){
	$option = [
		'idx_config' => $config->get('idx'),
		'title' => "Welcome to wooreeedu christmas event! $i",
		'content' => "Wooreeedu post content xmas $i just some added text here to try and find out if it still looks okay even when the content text is long...",
	];
	$post = post_data()->newPost($option);
	$data = $post->attachFile("theme/wooreeedu/img/xmas_$i.jpg");
}