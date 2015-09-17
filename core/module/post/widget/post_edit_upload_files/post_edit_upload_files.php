<?php
/**
 * @input $widget['form_name'] - is form name of HTML FORM type=file name='...'
 *
 */

$form_name = $widget['form_name'];
include template('element/file', 'data');
if ( is_post_edit_page() && $post = post_data()->getCurrent() ) {
    $files = data()->loadBy('post', $post->idx_config, $post->idx);
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