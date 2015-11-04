<?php
if( empty( $message_number ) ) $message_number = 0;
if( empty( $show_on_click_class ) ) $show_on_click_class = null;
if( empty( $placeholder ) ) $placeholder = "Send a message";

if( !empty( $user ) ) $user_id = $user->id;
else $user_id = "Anonymous";
?>
<div class='message-write-wrapper'>
	<form action='' no='reply-<?php echo $message_number ?>' class="ajax-file-upload message-form" method="post" enctype="multipart/form-data">  
		<?php 		
		echo "<input type='hidden' name='fid' value =''/>";
		?>
		<?php 
			echo html_hidden_post_variables(); 
			if( !empty( $reply ) ){
		?>
			<input type='hidden' name='user_id_to' value ='<?php echo $user_id; ?>'/>
		<?php } else{ ?>
			<div class='message-id-wrapper'>
				<span class='label'>To:</span>
				<input type='text' class='message-id' name='user_id_to' placeholder="User">
			</div>
		<?php } ?>
			<textarea class='message-content' name="content" placeholder="<?php echo $placeholder ?>"><?php if( !empty( $post['content'] ) ) echo $post['content']; ?></textarea>
	 
			<div class='buttons<?php echo $show_on_click_class; ?>'>
				<div class='post-file-upload-button'>
					<img src="<?php echo sysconfig(URL_SITE)?>module/app/img/camera_white_temp.png">
					사진 추가
				</div>
				<input class="form-comment-add-submit" type="submit" value="Send">
			</div>
			<div class='file-display files'></div>
	</form>
	<?php
	$message_number++;
	?>
</div>