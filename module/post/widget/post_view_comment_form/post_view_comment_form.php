<?php

$post = post_data()->getCurrent()->get();

?>


<div class="reply">
    <form name="comment" action="/post/comment/submit" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idx_parent" value="<?php echo $post['idx'] ?>">
        <input type="hidden" name="fid" value="">
        <textarea id="contentEditor<?php echo $post['idx'] ?>" name="content" onclick="loadReplyCKEditor('contentEditor<?php echo $post['idx'] ?>');" placeholder="Please, click here to reply a comment."></textarea>
        <input class="show-on-click" type='file' name='files[]' multiple onchange="jQuery(this).parent().submit();">
        <div class="uploaded-files" parent_id="{{ post.id.value }}"></div>
        <input class="show-on-click form-comment-add-submit" type="submit" value="UPLOAD COMMENT">
    </form>
</div>


