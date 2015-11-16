<?php
//$name = post_config()->getCurrent()->getWidget('list');//original
//widget($name, $variables);

$current = post_config()->getCurrent();
if( !empty( $current ) ){
	$name = $current->getWidget('list');
	widget($name, $variables);
}
else{
	$variables['message'] = "Incorrect Post ID.";
	include template('post.error');
}
?>