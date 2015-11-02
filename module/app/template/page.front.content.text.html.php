<?php
$posts = post()->getLatestPost('wooreeedu', 2, 2);
if ( empty($posts) ) return;

?>
<div class="text-list">
    <?php foreach ( $posts as $post ) {?>
        <div class='link' route='view_post' idx='<?php echo $post->idx?>'>
            <div class="row">
                <h3><?php echo $post->getTitle(64) ?></h3>
                <div class="comment"><?php echo $post->getDescription(64) ?></div>
            </div>
        </div>
    <?php } ?>
</div>
