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
add_css(null, __FILE__);
add_javascript(null, __FILE__);
$files = data()->loadBy('post', post_data($idx)->config('idx'), $idx);

if ( empty($files) ) return;
$total_files = count( $files );
?>
<section role="files">
    <div class="display-files" file_count='<?php echo $total_files; ?>'>
        <?php 
		if( $total_files > 1 ) display_files_thumbnail( $files, 200, 200 );
		else display_files($files); 
		?>
    </div>
</section>