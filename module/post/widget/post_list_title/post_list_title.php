<?php
/**
 * @input array $widget['post'] - is the array of post
 */
$post = &$widget['post'];
?>
<?php if ( $post['delete'] ) { ?>
    <a class='deleted' href="<?php echo $post['url']?>">
        This post is deleted.
    </a>
<?php } else { ?>
    <a href="<?php echo $post['url']?>"><?php echo $post['title']?></a>
<?php } ?>


