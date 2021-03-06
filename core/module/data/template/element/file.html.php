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

if ( isset($form_upload_single_file) && $form_upload_single_file == true ) $multiple = "";
else $multiple = "multiple";
$text = "<input type='file' name='$form_name' $multiple onchange='onFileChange(this);'>";
?>
<div class="ajax-file-upload-progress-bar"></div>
<?php
echo html_row([
    'class' => 'file-upload',
    'caption' => 'File Upload',
    'text' => $text,
]);
?>



