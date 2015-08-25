<?php
if ( empty($post) ) return;

?>
<div class="view">
    <h3 class='title'><?php widget('post_view_title', $variables)?></h3>
    <nav class=""><?php widget('post_view_menu', $variables)?></nav>
    <section class="content"><?php widget('post_view_content', $variables)?></section>
    <section role="files">
        <hr>File Widget<hr>
    </section>

    <section class="comment-form"><?php widget('post_view_comment_form')?></section>
    <section class="comment-list"><?php widget('post_view_comment_list')?></section>
</div>