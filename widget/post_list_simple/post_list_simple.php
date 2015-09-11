<?php widget('post_list_menu'); ?>

<?php
$posts = post()->postListData();
?>
<div class="list">
    <?php foreach( $posts as $post ) { ?>
        <div>
            <a href="<?php echo url_post_view($post)?>"><span><?php widget('post_list_title', ['post'=>$post]); ?></span></a>
            <a href="<?php echo url_post_view($post)?>"><span><?php echo date_short($post['created']);?></span></a>
        </div>
    <?php } ?>
</div>

<?php widget('post_list_navigator'); ?>
<?php widget('post_list_search_box', $widget); ?>
