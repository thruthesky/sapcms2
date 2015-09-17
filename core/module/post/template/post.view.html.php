<?php
add_css();
add_javascript();

$name = post_config()->getCurrent()->getWidget('view');
widget($name, module()->getVariables());
?>
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