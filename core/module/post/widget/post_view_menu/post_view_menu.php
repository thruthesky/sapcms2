<?php
add_css();
$url_list = post()->urlPostList(null, false);
$url_edit = post()->urlPostEdit();
$url_delete = post()->urlPostDelete();
$post = post_data()->getCurrent();
?>
<nav class="menu">
    No. view: <?php echo $post->no_view; ?>
    Date: <?php echo date_short($post->created); ?>
    <hr>
    <div class="buttons">
        <a href="<?php echo $url_list?>">TOP</a>
        <a href="<?php echo url_post_list()?>">LIST</a>
        <a href="<?php echo $url_edit?>">EDIT</a>
        <a href="<?php echo $url_delete?>">DELETE</a>
        <?php if ( is_post_admin() ) { ?>
            <a href="<?php echo $url_delete?>">DELETE THREAD</a>
        <?php } ?>
    </div>
</nav>