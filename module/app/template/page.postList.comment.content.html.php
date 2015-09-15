<?php if ( $comment['delete'] ) { ?>
    <div class="deleted">
        This post is deleted.
    </div>
<?php } else { ?>
    <?php echo $comment['content'] ?>
<?php } ?>