<?php
$url_primary_photo = login() ? login()->getPrimaryPhotoUrlThumbnail(80,80) : null;

if( !empty( $edit_mode ) ){
	$class=' edit';
	$no_comment_form = $no;
	$buttons_width = '105';
}
else {
	$class = '';
	$buttons_width = '55';
}

if( empty( $no_comment_form ) ) $no_comment_form = 0;
?>
<form action='' no='post-<?php echo $no_comment_form ?>' class="ajax-file-upload post-form<?php echo $class; ?>" method="post" enctype="multipart/form-data">  
	<?php 
	$post_id = request( 'post_id' );
	if( !empty( $post_id ) ) echo "<input type='hidden' name='id' value ='$post_id'/>";
	echo "<input type='hidden' name='idx_parent' value ='0'/>";
	echo "<input type='hidden' name='fid' value =''/>";
	if( !empty( $post['idx'] ) ) echo "<input type='hidden' name='idx' value='$post[idx]' />";
	?>
	<?php echo html_hidden_post_variables(); ?>
    <table width="100%" cellpadding="0" cellspacing="0">
            <tr valign="top">
				<td width="45">                    
					<?php if( !empty( $url_primary_photo ) ){?>
						<div class='primary-photo comment-photo'><img src='<?php echo $url_primary_photo; ?>'/></div>
					<?php } else {?>
						<div class='primary-photo comment-photo temp'><img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/no_primary_photo.png'/></div>
					<?php }?>
                </td>
				<td width="99%">
                    <textarea class='post-form-content' name="content"><?php if( !empty( $post['content'] ) ) echo $post['content']; ?></textarea>
                </td>                
            </tr>
        </table>
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr valign='top'>				
				<td>
					<img class="post-file-upload-button" src="<?php echo sysconfig(URL_SITE)?>module/app/img/camera_white_temp.png">
				</td>
				<td width='90%'>
					&nbsp;
				</td>
				<td width="10%">
					<div style='width:<?php echo $buttons_width; ?>px'>
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
