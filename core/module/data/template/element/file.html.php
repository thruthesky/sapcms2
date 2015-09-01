<?php
/**
 *
 * @input $file_upload_form_name
 *
 * @see https://docs.google.com/document/d/1jIstj8S93p44zuQgtv5EDIYPcwJmPR0QwVzyhZ7g6N0/edit#heading=h.tg74ui593wyx
 *
 */

add_css('core/module/data/css/file.css');
add_javascript('core/etc/js/jquery.form/jquery.form.min.js');
add_javascript('core/module/data/js/file.js');
if ( isset($file_upload_form_name) ) $form_name = $file_upload_form_name;
else $form_name = "files[]";

/**
 *
 */
if ( ! isset($set_fid) ) {
    $set_fid = true;
    echo '<input type="hidden" name="fid" value="">';
}

$text = "<input type='file' name='$form_name' multiple onchange='onFileChange(this);'>";
?>
<div class="ajax-file-upload-progress-bar"></div>
<?php
echo html_row([
    'class' => 'file-upload',
    'caption' => 'File Upload',
    'text' => $text,
]);
?>


<?php
if ( is_post_edit_page() && $post = post_data()->getCurrent() ) {
    $files = data()->loadBy('post', 'file', $post->idx);
    if ( $files ) {
        $uploaded = [];
        foreach( $files as $file ) {
            $f = $file->get();
            $f['url'] = $file->url();
            $uploaded[] = $f;
        }
        ?>
        <script>
            function setUploadedFiles() {
                var $form = $("[name='<?php echo $form_name ?>']").parents('form');
                var files = <?php echo json_encode($uploaded) ?>;
                fileDisplay($form, files);
            }
            setTimeout(setUploadedFiles, 200);
        </script>
    <?php }
}
?>