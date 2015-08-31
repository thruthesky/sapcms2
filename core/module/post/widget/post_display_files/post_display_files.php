<?php

add_css();
$files = data()->loadBy('post', 'file', post_data()->getCurrent()->get('idx'));
if ( empty($files) ) return;
?>
<div class="file-display">
    <?php foreach ( $files as $file ) { ?>
        <img src="<?php echo $file->url(); ?>">
    <?php } ?>
</div>