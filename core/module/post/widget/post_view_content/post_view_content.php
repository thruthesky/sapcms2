<?php
/**
 * @input array $widget['post'] is the Array of post or comment.
 */

$post = & $widget['post'];

?>
<section class="content">
    <?php if ( $post['delete'] ) { ?>
        <div class="deleted">
            This post is deleted.
        </div>
    <?php } else { ?>
        <?php echo $post['content'] ?>
    <?php } ?>
</section>