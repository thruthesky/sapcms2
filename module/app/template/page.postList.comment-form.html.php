<?php
if ( isset($comment) ) $post = $comment;
if ( $post['idx_parent'] ) $display = 'none';
else $display='block';
global $no_comment_form;
if ( isset($no_comment_form) ) $no_comment_form ++;
else $no_comment_form = 0;

?>
<form name="comment" no='<?php echo $no_comment_form; ?>' class="ajax-file-upload" method="post" enctype="multipart/form-data">    
    <input type="hidden" name="idx_parent" value="<?php echo $post['idx'] ?>">
    <input type="hidden" name="file_display" value="1">
    <input type="hidden" name="ajax" value="1">
    <?php echo html_hidden_post_variables(); ?>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr valign="top">
            <td width="40">
                <img class="file-upload-button" src="/core/module/post/img/camera.png">
				<input type="hidden" name="fid" value="">
                <?php include template('element/file', 'data'); ?>
            </td>
            <td width="99%">
                <textarea class='comment-form-content' name="content"></textarea>
                <input class="show-on-click form-comment-add-submit" type="submit" value="UPLOAD COMMENT">
            </td>
        </tr>
    </table>
    <div class='file-display files'></div>
</form>