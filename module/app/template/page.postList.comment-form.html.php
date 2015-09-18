<?php
if ( isset($comment) ) $post = $comment;
if ( $post['idx_parent'] ) $display = 'none';
else $display='block';
global $no_comment_form;
if ( isset($no_comment_form) ) $no_comment_form ++;
else $no_comment_form = 0;

//$primary_photo = null;
$user_idx = login('idx');
if( !empty( $user_idx ) ) $primary_photo = data()->loadBy('user', 'primary_photo', $user_idx );
if( !empty( $primary_photo ) ) $primary_photo = $primary_photo[0]->urlThumbnail(140,140);
?>
<form name="comment" no='<?php echo $no_comment_form; ?>' class="ajax-file-upload" method="post" enctype="multipart/form-data">    
    <input type="hidden" name="idx_parent" value="<?php echo $post['idx'] ?>">
    <input type="hidden" name="file_display" value="1">
    <input type="hidden" name="ajax" value="1">
    <?php echo html_hidden_post_variables(); ?>
    <table width="100%" cellpadding="0" cellspacing="0">
            <tr valign="top">
				<td width="45">                    
					<?php if( !empty( $primary_photo ) ){?>
						<div class='primary-photo comment-photo'><img src='<?php echo $primary_photo; ?>'/></div>
					<?php } else {?>
						<div class='primary-photo comment-photo temp'><img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/no_primary_photo.png'/></div>
					<?php }?>
                </td>
				<td width="99%">
                    <textarea class='comment-form-content' name="content"></textarea>                
                </td>
                <td width="40">
                    <img class="file-upload-button" src="<?php echo sysconfig(URL_SITE)?>module/app/img/camera_white_temp.png">
                    <?php include template('element/file', 'data'); ?>
                </td>
                <td width="55">
                    <input class="form-comment-add-submit" type="submit" value="POST">
                </td>
            </tr>
        </table>
        <div class='file-display files'></div>
</form>
