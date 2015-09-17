<?php
/**
 *
 * @input $widget['post'] - Array of Post Data Entity Record of (1) the root post or (2) parent comment.
 */
add_css(null, __FILE__);
add_javascript(null, __FILE__);
$post = $widget['post'];
if ( $post['idx_parent'] ) $display = 'none';
else $display='block';
global $no_comment_form;
if ( isset($no_comment_form) ) $no_comment_form ++;
else $no_comment_form = 0;

//$primary_photo = null;
$primary_photo = data()->loadBy('user', 'primary_photo', login('idx') );
if( !empty( $primary_photo ) ) $primary_photo = $primary_photo[0]->urlThumbnail(140,140);
?>

<section class="comment-form" style="display:<?php echo $display?>;">
    <form name="comment" no='<?php echo $no_comment_form; ?>' class="ajax-file-upload" action="/post/comment/submit" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idx_parent" value="<?php echo $post['idx'] ?>">
        <input type="hidden" name="file_display" value="1">
        <?php echo html_hidden_post_variables(); ?>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr valign="top">
				<td width="45">                    
					<?php if( !empty( $primary_photo ) ){?>
						<div class='show-on-click primary-photo comment-photo'><img src='<?php echo $primary_photo; ?>'/></div>
					<?php } else {?>
						<div class='show-on-click primary-photo comment-photo temp'></div>
					<?php }?>
                </td>
				<td width="99%">
                    <textarea class='comment-form-content' name="content"></textarea>                
                </td>
                <td width="40">
                    <img class="file-upload-button" src="/core/module/post/img/camera_white_temp.png">
                    <?php include template('element/file', 'data'); ?>
                </td>
                <td width="55">
                    <input class="show-on-click form-comment-add-submit" type="submit" value="POST">
                </td>
            </tr>
        </table>
        <div class='file-display files'></div>
    </form>
</section>