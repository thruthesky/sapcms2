<?php
$posts_text = getPostWithImageNoComment(0, 2, 'wooreeedu');
if ( empty($posts_text) ) return;

?>
<div class="text-list">
    <?php foreach ( $posts_text as $pt ) {?>
        <div class='link' route='view_post' idx='<?php echo $pt->idx?>'>
            <div class="row">
                <h3><?php echo $pt->getTitle(64) ?></h3>
                <div class="comment"><?php echo $pt->getDescription(64) ?></div>
            </div>
        </div>
    <?php } ?>
</div>
