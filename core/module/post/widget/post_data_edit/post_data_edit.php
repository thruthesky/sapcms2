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
    <input type="hidden" name="file_module" value="post">
    <input type="hidden" name="file_type" value="file">
    <input type="hidden" name="file_idx_target" value="123">
    <input type="hidden" name="file_display" value="1">
    <input type="hidden" name="file_callback" value="callback_edit_file_upload">
    <?php include template('element/hidden.variables'); ?>
    <?php include template('element/title'); ?>
    <?php include template('element/file', 'data'); ?>
    <?php include template('element/content'); ?>
    <?php $file_upload_form_name='books[]'; include template('element/file', 'data'); ?>
    <input type="submit" value="UPDATE POST">
</form>
<script>
    CKEDITOR.replace( 'contentEditor', {
        uiColor: '#f0f0f0'
    } );
</script>
<script>
    function callback_edit_file_upload(files) {
        console.log(file_upload_form_name);
        console.log(files);
    }
</script>

