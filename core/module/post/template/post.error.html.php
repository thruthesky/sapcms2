<?php	
	extract( $variables );
	if( !empty( $error ) ){
?>
<div class='post-error'>
<h3><?php echo $error['code'] ?> [ <?php echo $error['message'] ?> ]</h3>
</div>
<?php } ?>