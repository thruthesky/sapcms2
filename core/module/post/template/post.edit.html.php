<?php
//$name = post_config()->getCurrent()->getWidget('list');//original
//widget($name, $variables);

$current = post_config()->getCurrent();
if( !empty( $current ) ){
	$name = $current->getWidget('edit');
	widget($name, $variables);
}
else{
	$variables['error']['code'] = "-50001";
	$variables['error']['message'] = "Incorrect Post ID.";
	include template('post.error');
}
?>