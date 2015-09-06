<?php
/**
 * @input array $widget['post'] - is the array of post
 */
$post = &$widget['post'];
?>
<?php if ( $post['delete'] ) { ?>
    <span class='deleted'>
        This post is deleted.
    </span>
<?php } else { ?>
    <?php echo strcut($post['title'], 128, '...')?>
<?php } ?>


