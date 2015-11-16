<?php	
	extract( $variables );
	if( !empty( $error ) ){
?>
<div class='post-error'>
	<div class='postNotice error'><?php echo $error['code'] ?> [ <?php echo $error['message'] ?> ]</div>
</div>
<?php } ?>