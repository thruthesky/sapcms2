<?php
/*
$image_fhm = post()->getLatestPostImage(7,'wooreeedu');
$src_fhm = $image_fhm->urlThumbnail(45, 45);
$fhm = post_data($image_fhm->idx_target);

$image_news = post()->getLatestPostImage(8,'wooreeedu');
$src_news = $image_news->urlThumbnail(45, 45);
$news = post_data($image_news->idx_target);

if( empty( $news ) ) return;
if( empty( $fhm ) ) return;
*/
?>
<div class="text-with-thumbnail">
<?php
$post_items = array_slice( $posts_gallery, 3, 2 );
foreach( $post_items as $pi ){
$src = $pi->getImage()->urlThumbnail(45, 45);
?>
    <div class='link' route='view_post' idx='<?php echo $pi->idx?>''>
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td width="5%"><img class='thumbnail' src="<?php echo $src?>"></td>
                <td width="93%">
                    <div class="content">
                        <h3><?php echo $pi->getTitle(64) ?></h3>
                        <div class="comment"><?php echo $pi->getDescription(64) ?></div>
                    </div>
                </td>
                <td width="2%"><img src="<?php echo url_site();?>/theme/default/tmp/news2.png"</td>
            </tr>
        </table>
    </div>
<?php
}
?>
</div>