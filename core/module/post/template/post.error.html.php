<?php	
	extract( $variables );
	if( !empty( $message ) ){
?>
<div class='post-error'>
<h2><?php echo $message ?></h2>
</div>
<?php } ?>