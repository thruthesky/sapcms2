<?php
add_css();
$top_banner = post()->getLatestPostImage();

if ( empty($top_banner) ) return;
$top_post = post_data()->load( $top_banner->idx_target );
$top_idx = null;
if( !empty( $top_post ) ) $top_idx = $top_post->idx;

$src_top_banner = $top_banner->urlThumbnail(400, 200);
$top = post_data($top_banner->idx_target);

if ( empty($top) ) return;

$items = null;
$images = post()->getLatestPostImages(1, 6, 'wooreeedu');
if ( $images ) {
    foreach ( $images as $image ) {
        $src = $image->urlThumbnail(120,120);
		
		$post = post_data()->load( $image->idx_target );
		$idx = null;
		if( !empty( $post ) ) $idx = $post->idx;		
		
        $items .= "<img class='link' route='view_post' idx='$idx' src='$src'>";
    }
}
?>
<div class="front-top-banner">
    <span class='link' route='view_post' idx='<?php echo $top_idx; ?>'><img src="<?php echo $src_top_banner ?>"></span>
</div>
<div class="front-content">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr valign="top">
            <td width="99%">
                <?php include template('page.front.content.text-with-thumbnail') ?>
                <?php include template('page.front.content.text') ?>
                <?php include template('page.front.content.text-photo') ?>
            </td>
            <td class='right' width="1%"><div class="thumbnail-list"><?php echo $items ?></div></td>
        </tr>
    </table>
</div>


