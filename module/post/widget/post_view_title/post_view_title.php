<?php
$post = &$variables['post'];
?>
<?php if ( $post['delete'] ) { ?>
    This post is deleted.
<?php } else { ?>
    <?php echo $post['title'] ?>
<?php } ?>