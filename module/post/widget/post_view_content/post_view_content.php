<?php
$post = &$variables['post'];
?>
<?php if ( $post['deleted'] ) { ?>
    This post is deleted.
<?php } else { ?>
    <?php echo $post['content'] ?>
<?php } ?>
