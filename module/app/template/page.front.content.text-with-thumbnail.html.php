<?php
$image_fhm = post()->getLatestPostImage(7);
$src_fhm = $image_fhm->urlThumbnail(45, 45);
$fhm = post_data($image_fhm->idx_target);

$image_news = post()->getLatestPostImage(8);
$src_news = $image_news->urlThumbnail(45, 45);
$news = post_data($image_news->idx_target);

if( empty( $news ) ) return;
if( empty( $fhm ) ) return;

?>
<div class="text-with-thumbnail">
    <div class='link' route='view_post' idx='<?php echo $fhm->idx?>''>
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td width="5%"><img class='thumbnail' src="<?php echo $src_fhm?>"></td>
                <td width="93%">
                    <div class="content">
                        <h3><?php echo $fhm->getTitle(64) ?></h3>
                        <div class="comment"><?php echo $fhm->getDescription(64) ?></div>
                    </div>
                </td>
                <td width="2%"><img src="<?php echo url_site();?>/theme/default/tmp/fhm.png"</td>
            </tr>
        </table>
    </div>

    <div class='link' route='view_post' idx='<?php echo $news->idx?>''>
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td width="5%"><img class='thumbnail' src="<?php echo $src_news?>"></td>
                <td width="93%">
                    <div class="content">
                        <h3><?php echo $news->getTitle(64) ?></h3>
                        <div class="comment"><?php echo $news->getDescription(64) ?></div>
                    </div>
                </td>
                <td width="2%"><img src="<?php echo url_site();?>/theme/default/tmp/news2.png"</td>
            </tr>
        </table>
    </div>
</div>
