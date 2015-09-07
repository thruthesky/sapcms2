<?php
$image_fhm = post()->getLatestPostImage(7);
$src_fhm = $image_fhm->urlThumbnail(45, 45);
$fhm = post_data($image_fhm->idx_target);

$image_news = post()->getLatestPostImage(8);
$src_news = $image_news->urlThumbnail(45, 45);
$news = post_data($image_news->idx_target);
?>
<div class="text-with-thumbnail">
    <a href="<?php echo $fhm->url()?>">
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td width="5%"><img class='thumbnail' src="<?php echo $src_fhm?>"></td>
                <td width="93%">
                    <div class="content">
                        <h3><?php echo $fhm->getTitle(64) ?></h3>
                        <div class="comment"><?php echo $fhm->getDescription(64) ?></div>
                    </div>
                </td>
                <td width="2%"><img src="/theme/default/tmp/fhm.png"</td>
            </tr>
        </table>
    </a>

    <a href="<?php echo $news->url()?>">
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td width="5%"><img class='thumbnail' src="<?php echo $src_news?>"></td>
                <td width="93%">
                    <div class="content">
                        <h3><?php echo $news->getTitle(64) ?></h3>
                        <div class="comment"><?php echo $news->getDescription(64) ?></div>
                    </div>
                </td>
                <td width="2%"><img src="/theme/default/tmp/news2.png"</td>
            </tr>
        </table>
    </a>
</div>
