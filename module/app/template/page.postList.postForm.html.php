<?php
$url_primary_photo = login() ? login()->getPrimaryPhotoUrlThumbnail(80,80) : null;
?>
<form action='/post/create/submit' class="ajax-file-upload post-form" method="post" enctype="multipart/form-data">  
	<?php 
	$post_id = request( 'post_id' );
	if( !empty( $post_id ) ) echo "<input type='hidden' name='id' value ='$post_id'/>";
	echo "<input type='hidden' name='idx_parent' value ='0'/>";
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
                    <textarea class='post-form-content' name="content"></textarea>                
                </td>                
            </tr>
        </table>
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr valign='top'>
				<td width='50%'>
					&nbsp;
				</td>
				<td>
					<img class="post-file-upload-button" src="<?php echo sysconfig(URL_SITE)?>module/app/img/camera_white_temp.png">
				</td>
				<td width="10%">
					<input class="form-comment-add-submit" type="submit" value="POST">
				</td>
			</tr>
		</table>
        <div class='file-display files'></div>
</form>
