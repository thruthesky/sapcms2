<?php
$post = post_data()->getCurrent()->getFields();
?>
<?php if ( $post['delete'] ) { ?>
    This post is deleted.
<?php } else { ?>
    <?php echo nl2br($post['content']) ?>
<?php } ?>
