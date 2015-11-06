<?php
add_css();
$posts_gallery = getPostWithImageNoComment(0, 11, 'wooreeedu_gallery');
if( empty( $posts_gallery ) ) return;

//top_post
$top_post = $posts_gallery[0];
$top_idx = null;
if( !empty( $top_post ) ) $top_idx = $top_post->idx;
$src_top_banner = $top_post->getImage()->urlThumbnail(400, 200);

//thumbnail items
$items = null;
$post_items = array_slice( $posts_gallery, 5, 6 );
foreach( $post_items as $pi ){
	$src = $pi->getImage()->urlThumbnail(120,120);
	$idx = $pi->idx;
	$items .= "<img class='link' route='view_post' idx='$idx' src='$src'>";
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


