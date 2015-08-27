<form  method="post">
    <?php include template('user.form'); ?>
	<?php
	if( empty( $user ) ) $submit_text = "REGISTER";
	else $submit_text = "UDPATE";
	?>
    <input type="submit" value="<?php echo $submit_text ?>">
    <a href="/" class="ui-btn ui-icon-action">CANCEL</a>
</form>