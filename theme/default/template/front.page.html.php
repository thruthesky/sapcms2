<?php
//$data = data()->query("module='post' ORDER BY idx DESC");
//$file = post()->data()->files();
//$src = $file->url();

$src_top_banner = post()->getLatestPostImage()->urlThumbnail(400, 200);

$items = null;
$images = post()->getImagesOfLatestPosts(5, 'test');
if ( $images ) {
    foreach ( $images as $image ) {
        $src = $image->urlThumbnail(180,180);
        $items .= "<img src='$src'>";
    }
}

?>

<img src="<?php echo $src_top_banner ?>" style="width:100%;">
<?php echo $items ?>
    <?php widget('login-box'); ?>

