<?php
$posts = post()->getLatestPost('test', 2, 2);
if ( empty($posts) ) return;
?>
<div class="text-list">
    <?php foreach ( $posts as $post ) { ?>
        <a href="<?php echo $post->url()?>">
            <div class="row">
                <h3><?php echo $post->getTitle(64) ?></h3>
                <div class="comment"><?php echo $post->getDescription(64) ?></div>
            </div>
        </a>
    <?php } ?>
</div>
