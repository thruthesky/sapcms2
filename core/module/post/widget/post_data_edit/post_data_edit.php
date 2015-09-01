<?php
$config = post_config()->getCurrent();
$data = post_data()->getCurrent();
if ( $data ) {
    $idx = $data->idx;
    $title = $data->get('title');
    $content = $data->get('content');
}
else {
    $idx = 0;
    $title = request('title');
    $content = request('content');
}
?>
<script src="/core/etc/editor/ckeditor/ckeditor.js"></script>
<form class="ajax-file-upload" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $config->id; ?>">
    <input type="hidden" name="idx" value="<?php echo $idx; ?>">
    <input type="hidden" name="file_display" value="1">
    <?php include template('element/hidden.variables'); ?>
    <?php include template('element/title'); ?>
    <?php include template('element/file', 'data'); ?>
    <?php include template('element/content'); ?>
    <input type="submit" value="UPDATE POST">
    <a href="<?php echo url_go_back();?>">Cancel</a>
</form>
<script>
    CKEDITOR.replace( 'contentEditor', {
        uiColor: '#f0f0f0'
    } );
</script>

