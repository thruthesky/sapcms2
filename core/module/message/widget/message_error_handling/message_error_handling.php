<?php
if( !empty( $widget ) ){
	add_css();
	$class = '';
	if( $widget['code'] != 0 ) $class = ' error';
?>
	<div class='message-error-handling<?php echo $class ?>'>
		<?php if( $widget['code'] != 0 ) {?>
			<div class='code'>Code [ <?php echo $widget['code'] ?> ]</div>
		<?php } ?>
		<div class='message'><?php echo $widget['message'] ?></div>
	</div>
<?php } ?>