<?php
$file = data()->loadBy('user', 'primary_photo', login('idx'));
if ( $file ) $src = $file[0]->urlThumbnail(140,140);
else $src = "/tmp/user.png";
?>

<script>
    function callback_user_primary_photo_upload (files) {
        console.log("callback_user_primary_photo_upload ");
        console.log(files);
        if ( files ) {
            var file = files[0];
            if ( file.error ) alert( file.message );
            else {
                $(".user-primary-photo img").prop('src', file.urlThumbnail);
            }
        }
    }
</script>

<div class="user-primary-photo">
    <img src="<?php echo $src?>">
<?php
/**
 * @input $widget['form_name'] - is form name of HTML FORM type=file name='...'
 *
 */
$form_upload_single_file = true;
include template('element/file', 'data');
?>
</div>