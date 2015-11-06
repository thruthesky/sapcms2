<?php
	add_css();
	add_javascript();
	
	widget('message_list_menu', $variables);
	extract( $variables );
	$send_id = "";
	if( !empty( $input['send_id'] ) ) $send_id = $input['send_id'];
	
	$action = '/message/send';	
	
	$fid = "";
	$user_id_to = "";
	$title = "";
	$content = "";
	
	if( !empty( $input['fid'] ) ) $fid = $input['fid'];
	if( !empty( $input['user_id_to'] ) ) $user_id_to = $input['user_id_to'];
	if( !empty( $input['title'] ) ) $title = $input['title'];
	if( !empty( $input['content'] ) ) $content = $input['content'];
?>
<?php widget( 'message_error_handling', $options ); ?>
<div class='message-create'>
<?php if( !empty( $send_id ) ){?>
	<h1>Reply to <?php echo $send_id ?></h1>
<?php }else { ?>
	<h1>Send a message</h1>
<?php } ?>
	<form action="<?php echo $action ?>" class="ajax-file-upload" method="post" enctype="multipart/form-data">
		<div class='file-display'></div>
		<?php include template('element/file', 'data'); ?>
		<?php
		//in case of error or fail of message, do not forget the previously uploaded fids
		//copied from post_edit_upload_files
		$fids = explode(",", $fid );
		$files = [];
		foreach( $fids as $f ){
			if( empty( $f ) ) continue;
			$files[] = data()->load( $f );
		}
		
		if ( !empty( $files ) ) {
			$uploaded = [];
			foreach( $files as $file ) {
				$f = $file->get();
				$f['url'] = $file->url();
				$uploaded[] = $f;
			}
			?>
			<script>
				function setUploadedFiles() {
					var $form = $("[name='fid']").parents('form');					
					var files = <?php echo json_encode($uploaded) ?>;
					fileDisplay($form, files);
					$form.find("[name='fid']").val( '<?php echo $fid ?>' );//added
				}
				setTimeout(setUploadedFiles, 200);
			</script>
		<?php }
		//eo in case of error or fail of message, do not forget the previously uploaded fids
		?>
		<input type="hidden" name="file_display" value="1">

		<table cellpadding=0 cellspacing=0 width='100%'>		
			<?php if( !empty( $send_id ) ){?>
			<input type='hidden' name='user_id_to' value='<?php echo $send_id ?>' />	
				<?php }else { ?>
				<tr valign='top'>
					<td width='100'>ID</td><td><input type='text' name='user_id_to' value='<?php echo $user_id_to ?>'/></td>
				</tr>
				<?php } ?>
				<tr valign='top'>
					<td>TITLE</td><td><input type='text' name='title' value='<?php echo $title ?>'></td>
				</tr>
				<tr valign='top'>
					<td>CONTENT</td><td><textarea name='content'><?php echo $content ?></textarea></td>
				</tr>
		</table>		
		<input type='submit' value='Send'>
	</form>
</div>