<?php
add_css();
add_javascript();

?>
<div class="view">
    <?php widget('post_view_title', $variables)?>
    <?php widget('post_view_menu', $variables)?>
    <?php widget('post_view_vote', ['post'=>post_data()->getCurrent()->get()])?>
    <?php widget('post_view_content', ['post'=>post_data()->getCurrent()->getFields()])?>
    <?php widget('post_display_files', ['idx'=>post_data()->getCurrent()->get('idx')])?>
    <?php widget('post_view_comment_form', ['post'=>post_data()->getCurrent()->get()])?>
    <?php widget('post_view_comment_list')?>
</div>
<?php if ( $idx_comment = request('idx_comment') ) { ?>
    <script>
        var idx_comment = '<?php echo $idx_comment?>';
    </script>
<?php } ?>

<?php
    if ( post()->config('show_list_under_view') == 'Y' ) {
        include template('post.list');
    }
?>