<?php
$posts = post()->getLatestPost('test', 9, 2);
if ( empty($posts) ) return;
?>
<div class="text-photo">
    <?php
    foreach ( $posts as $post ) {
		$img = $post->getImage();
        if( !empty( $img ) ) $photo = "<img src='".$img->urlThumbnail(400,140)."'/>";
		else $photo = null;
        ?>
        <a href="<?php echo $post->url()?>">
            <div class="row">
                <div class="photo">					
                    <?php echo $photo; ?>
                </div>
                <div class="text">
                    <h3 class="title"><?php echo $post->getTitle(64)?></h3>
                    <hr>
                    <div class="description"><?php echo $post->getDescription(100)?> ...</div>
                    <div class="buttons">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr valign="top">
                                <td>
                                    <div class="button">
                                        <img class='eye' src="/theme/default/tmp/eye.png">
                                        <?php echo $post->no_view?>
                                    </div>
                                </td>
                                <td>
                                    <div class="button">
                                        <img class='heart' src="/theme/default/tmp/heart.png">
                                        <?php echo $post->no_vote_good?>
                                    </div>
                                </td>
                                <td>
                                    <div class="button">
                                        <img class='reply' src="/theme/default/tmp/reply.png">
                                        <?php echo $post->no_comment?>
                                    </div>
                                </td>
                                <td align="right">
                                    <div class="button more">
                                        <img class='more' src="/theme/default/tmp/see-more.png">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </a>
    <?php } ?>
</div>
