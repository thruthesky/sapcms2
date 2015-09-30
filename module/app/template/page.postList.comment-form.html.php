<?php
if ( isset($comment) ){
	$post = $comment;
	//di( $comment );
}
if ( isset( $post['idx_parent'] ) ) $display = 'none';
else $display='block';
global $no_comment_form;
if ( isset($no_comment_form) ) $no_comment_form ++;
else $no_comment_form = 0;

$url_primary_photo = login() ? login()->getPrimaryPhotoUrlThumbnail(80,80) : null;

if( !empty( $edit_mode ) ) {
	$class=' comment-edit';
	$no_comment_form = $no;
	$buttons_width = '145';
}
else{
	$class = '';
	$buttons_width = '95';
}
?>
<form name="comment" no='<?php echo $no_comment_form; ?>' class="ajax-file-upload<?php echo $class; ?>" method="post" enctype="multipart/form-data">
	<?php if( empty( $edit_mode ) ){ ?>
		<input type="hidden" name="idx_parent" value="<?php echo $post['idx'] ?>">
	<?php } ?>
	<?php
		if( !empty( $comment_edit['idx'] ) ){
			echo "<input type='hidden' name='idx' value='$comment_edit[idx]' />";
		}
	?>
    <?php echo html_hidden_post_variables(); ?>
    <table width="100%" cellpadding="0" cellspacing="0">
		<tr valign="top">
			<td class='td-primary-photo' width="45">                    
				<?php if( !empty( $url_primary_photo ) ){?>
					<div class='primary-photo comment-photo'><img src='<?php echo $url_primary_photo; ?>'/></div>
				<?php } else {?>
					<div class='primary-photo comment-photo temp'><img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/no_primary_photo.png'/></div>
				<?php }?>
			</td>
			<td width="99%">
				<textarea class='comment-form-content' name="content"><?php if( !empty( $comment_edit['content'] ) ) echo $comment_edit['content']; ?></textarea>                
			</td>
		</tr>					
	</table>
	<table class='show-on-click' width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td width='99%'>
							&nbsp;
						</td>
						<td width="1%">							
							<div style='width:<?php echo $buttons_width; ?>px'>
								<img class="post-file-upload-button" src="<?php echo sysconfig(URL_SITE)?>module/app/img/camera_white_temp.png">
								<input type="hidden" name="fid" value="">
								<input class="form-comment-add-submit" type="submit" value="POST">
								<?php if( !empty( $edit_mode ) ) {?>
									<div class='post-cancel' type='comment'>Cancel</div>
								<?php }?>
							</div>
						</td>
					</tr>
				</table>
        <div class='file-display files'></div>
</form>
