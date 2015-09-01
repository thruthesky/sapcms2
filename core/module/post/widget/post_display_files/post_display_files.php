<?php
/**
 * Displays uploaded files/photos.
 *
 * @input int $widget['idx'] is the idx of post or comment
 * @code
 * <?php widget('post_display_files', ['idx'=>$comment['idx']])?>
 * @endcode
 *
 */
$idx = & $widget['idx'];
add_css();
$files = data()->loadBy('post', 'file', $idx);
if ( empty($files) ) return;
?>
    <div class="display-files">
        <?php foreach ( $files as $file ) { ?>
            <div>
                <?php display_file($file); ?>
            </div>
        <?php } ?>
    </div>

<?php
