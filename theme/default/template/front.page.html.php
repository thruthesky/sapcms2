<?php
add_css();
//$data = data()->query("module='post' ORDER BY idx DESC");
//$file = post()->data()->files();
//$src = $file->url();

$src_top_banner = post()->getLatestPostImage()->urlThumbnail(400, 200);

$items = null;
$images = post()->getImagesOfLatestPosts(1, 6, 'test');
if ( $images ) {
    foreach ( $images as $image ) {
        $src = $image->urlThumbnail(100,100);
        $items .= "<img src='$src'>";
    }
}

?>
<div class="front-top-banner">
    <img src="<?php echo $src_top_banner ?>">
</div>
<div class="front-content">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr valign="top">
            <td width="99%">abc</td>
            <td width="1%"><?php echo $items ?></td>
        </tr>
    </table>
</div>
<?php widget('login-box'); ?>

