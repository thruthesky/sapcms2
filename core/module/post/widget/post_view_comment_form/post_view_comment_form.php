<?php
/**
 *
 * @input $widget['post'] - Array of Post Data Entity Record of (1) the root post or (2) parent comment.
 */

$post = $widget['post'];

?>


<div class="reply">
    <form name="comment" class="ajax-file-upload" action="/post/comment/submit" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idx_parent" value="<?php echo $post['idx'] ?>">
        <input type="hidden" name="file_display" value="1">
        <?php echo html_hidden_post_variables(); ?>
        <img class="file-upload-button" src="/core/module/post/img/camera.png">
        <?php include template('element/file', 'data'); ?>
        <textarea name="content"></textarea>
        <input class="show-on-click form-comment-add-submit" type="submit" value="UPLOAD COMMENT">
    </form>
</div>
