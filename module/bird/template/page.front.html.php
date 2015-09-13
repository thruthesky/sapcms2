<?php
add_css();
$top_banner = post()->getLatestPostImage();
if ( empty($top_banner) ) return;
$src_top_banner = $top_banner->urlThumbnail(400, 200);
$top = post_data($top_banner->idx_target);
if ( empty($top) ) return;


$items = null;
$images = post()->getLatestPostImages(1, 6, 'test');
if ( $images ) {
    foreach ( $images as $image ) {
        $src = $image->urlThumbnail(120,120);
        $items .= "<img src='$src'>";
    }
}
?>
<div class="front-top-banner">
    <a href="<?php //echo $top->url()?>"><img src="<?php echo $src_top_banner ?>"></a>
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
<?php widget('login-box'); ?>


