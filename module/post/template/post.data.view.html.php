<?php
if ( empty($post) ) return;
add_css();
add_javascript();
?>
<script src="/core/etc/editor/ckeditor/ckeditor.js"></script>
<div class="view">
    <h3 class='title'><?php widget('post_view_title', $variables)?></h3>
    <nav class=""><?php widget('post_view_menu', $variables)?></nav>
    <section class="content"><?php widget('post_view_content', $variables)?></section>
    <section role="files"><?php widget('post_display_files')?></section>
    <section class="comment-form"><?php widget('post_view_comment_form')?></section>
    <section class="comment-list"><?php widget('post_view_comment_list')?></section>
</div>
<?php if ( $idx_comment = request('idx_comment') ) { ?>
    <script>
        var idx_comment = '<?php echo $idx_comment?>';
    </script>
<?php } ?>