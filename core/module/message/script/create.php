<?php
use sap\core\message\Message;
use sap\core\user\User;

$user_one = user()->load( 1 );
if( empty( $user_one ) ){
	echo "User IDX 1 does not exists... Exit now...";
	exit;
}
$user_two = user()->load( 2 );
if( empty( $user_two ) ){
	echo "User IDX 2 does not exists... Exit now...";
	exit;
}
for( $i=0; $i<1000; $i++ ){
	if( $i % 2 == 0 ){
		$idx_from = $user_one->idx;
		$idx_to = $user_two->idx;
	}
	else{
		$idx_to = $user_one->idx;
		$idx_from = $user_two->idx;
	}
	
	$title = $idx_from." to ".$idx_to." num [ $i ]";
	$content = "$i.) This is a fake message... Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vitae eros nec nunc dignissim hendrerit vitae quis justo. Nulla fringilla at sem ut porta. Etiam commodo aliquam ligula, cursus imperdiet dolor consectetur at. Pellentesque augue nunc, bibendum a fringilla vel, congue vel sapien. Donec mollis quis ex ut semper. Donec luctus blandit lobortis. Donec nulla quam, interdum in dolor at, blandit facilisis ante. Nunc nec ante a sem vehicula egestas a et magna. Ut scelerisque tempus vulputate. Pellentesque leo neque, vestibulum nec massa in, molestie dapibus felis. Sed sed accumsan purus. Donec id malesuada nisl. Integer mattis nibh interdum vestibulum euismod. Interdum et malesuada fames ac ante ipsum primis in faucibus.";
	
	message()->set('idx_from',$idx_from)
			->set('idx_to',$idx_to)
			->set('title', $title)
			->set('content', $content)
			->save();
}