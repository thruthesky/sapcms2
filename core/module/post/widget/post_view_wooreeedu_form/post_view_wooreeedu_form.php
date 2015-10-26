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

$user_idx = login('idx');
if( !empty( $user_idx ) ) {
	$user = user()->load( $user_idx );
	$user_photo = data()->loadBy('user', 'primary_photo', 0, $user->idx);
}
if( empty( $user_photo ) ) $user_photo = "/core/module/post/widget/post_view_wooreeedu_form/img/no_primary_photo.png";


?>

<section class="comment-form wooreeedu" style="display:<?php echo $display?>;">
    <form no='<?php echo $no_comment_form; ?>' class="ajax-file-upload" action="/post/comment/submit" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idx_parent" value="<?php echo $post['idx'] ?>">
        <input type="hidden" name="file_display" value="1">
        <?php echo html_hidden_post_variables(); ?>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr valign="top">
                <td width="90">
					<div class='primary-photo'>
						<img src='<?php echo $user_photo; ?>'/>
					</div>
                </td>
                <td width="99%">
                    <textarea class='comment-content' name="content"></textarea>                    
                </td>
				<td width="130">
					<div class='buttons'>
						<div class='file-upload-button'>
							<img src="/core/module/post/widget/post_view_wooreeedu_form/img/camera_white_temp.png">
						</div>
						<?php include template('element/file', 'data'); ?>
						<input class="form-comment-add-submit" type="submit" value="Reply">
					</div>
                </td>
            </tr>
        </table>
        <div class='file-display files'></div>
    </form>
</section>