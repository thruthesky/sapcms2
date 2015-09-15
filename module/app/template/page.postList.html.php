<?php

?>
<div class="post-list">
<?php foreach ( $posts as $post ) { ?>
    <div class="post">
        <?php echo $post['idx']; ?>
        <div class="title">
            <?php echo $post['title']; ?>
        </div>
        <div class="content">
            <?php echo $post['content']; ?>
        </div>
        <div class="comment-form">
            <?php include template('page.postList.comment-form') ?>
        </div>
        <div class="comments">
            <?php include template('page.postList.comments'); ?>
        </div>
    </div>
<?php } ?>
</div>