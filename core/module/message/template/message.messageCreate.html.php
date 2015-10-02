<?php
	add_css();
	add_javascript();
	
	widget('message_list_menu', $variables);
	extract( $variables );
	$send_id = "";
	if( !empty( $input['send_id'] ) ) $send_id = $input['send_id'];
	
	$action = '/message/send';
?>
<div class='message-create'>
<?php if( !empty( $send_id ) ){?>
	<h1>Reply to <?php echo $send_id ?></h1>
<?php }else { ?>
	<h1>Send a message</h1>
<? } ?>
<form action="<?php echo $action ?>" class="ajax-file-upload" method="post" enctype="multipart/form-data">
	<div class='file-display'></div>
	<?php include template('element/file', 'data'); ?>
	<input type="hidden" name="file_display" value="1">
	<input type='hidden' name='fid'>
	<?php if( !empty( $send_id ) ){?>
	<input type='hidden' name='user_id_to' value='<?php echo $send_id ?>' />
	<?php }else { ?>
	ID <input type='text' name='user_id_to'/><br>
	<? } ?>
	TITLE <input type='text' name='title'><br>
	CONTENT <textarea name='content'></textarea>
	<input type='submit' value='send'>
</form>
</div>