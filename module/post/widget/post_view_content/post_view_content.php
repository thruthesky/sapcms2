<?php
$post = post_data()->getCurrent()->getFields();
?>
<?php if ( $post['delete'] ) { ?>
    This post is deleted.
<?php } else { ?>
    <?php echo $post['content'] ?>
<?php } ?>
