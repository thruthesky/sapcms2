<?php
/**
 * @input $widget['post'] - is the post.
 */
add_css();
$post = &$widget['post'];
?>
<h3 class='title'>
    <?php if ( $post['delete'] ) { ?>
        This post is deleted.
    <?php } else { ?>
        <?php echo $post['title'] ?>
    <?php } ?>
</h3>
