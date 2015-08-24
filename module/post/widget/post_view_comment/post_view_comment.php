<?php

$post = post_data()->getCurrent()->get();

?>
<form action="/post/edit/submit">
    <input type="hidden" name="idx_root" value="<?php echo $post['idx'] ?>">
    <textarea name="content"></textarea>
    <input type="submit" value="ADD COMMENT">
</form>

