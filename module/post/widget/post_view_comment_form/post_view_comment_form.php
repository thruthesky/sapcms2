<?php
/**
 *
 * @input $widget['post'] - Array of Post Data Entity Record of (1) the root post or (2) parent comment.
 */

$post = $widget['post'];

?>


<div class="reply">
    <form name="comment" action="/post/comment/submit" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idx_parent" value="<?php echo $post['idx'] ?>">
        <input type="hidden" name="fid" value="">
        <?php echo html_hidden_post_variables(); ?>

        <img class="file-upload-button" src="/module/post/img/camera.png">
        <textarea name="content"></textarea>

        <div class="uploaded-files"></div>
        <input class="show-on-click form-comment-add-submit" type="submit" value="UPLOAD COMMENT">
    </form>
</div>
