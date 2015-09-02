<?php
	extract( $variables );
	
	
	if( !empty( $user ) ){
	//di( $user );
	if( !empty( $user['block'] ) ) $block_date = date( "Y-m-d", $user['block']	);
	else $block_date = null;
?>
	<h1>Fill in the input boxes to block user: <?php echo $user['name']?> ( <?php echo $user['idx']?> )</h1>

	<form method='post'>
		<input type='hidden' name='idx' value='<?php echo $user['idx']?>'>
		Reason for blocking
		<textarea name='block_reason'><?php echo $user['block_reason']?></textarea>
		Block until
		<input type='date' name='block' value='<?php echo $block_date ?>'>
		<input type='submit' value='BLOCK'>
	</form>

<?php
	}
?>