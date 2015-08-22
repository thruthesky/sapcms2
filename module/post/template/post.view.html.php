<?php
if ( empty($post) ) return;
?>

<h3 class='title'>
    <hr>Title Widget<hr>
    <?php if ( $post['deleted'] ) { ?>
        This post is deleted.
    <?php } else { ?>
        <?php echo $post['title'] ?>
    <?php } ?>
</h3>
<nav>
    <hr>Menu Widget</hr>
</nav>
<section class="content">
    <hr>Content Widget<hr>
    <?php if ( $post['deleted'] ) { ?>
        This post is deleted.
    <?php } else { ?>
        <?php echo $post['content'] ?>
    <?php } ?>
</section>

<section role="files">
    <hr>File Widget<hr>
</section>
