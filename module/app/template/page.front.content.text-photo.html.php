<?php
$posts = post()->getLatestPostImages(9, 2, 'test');
?>
<div class="text-photo">
    <?php
    foreach ( $posts as $post ) {
		$post = post_data()->load($post->idx_target);
		$post_image = $post->getImage();
		if( !empty( $post_image ) ) $src = $post->getImage()->urlThumbnail(400,140);
		else $src = null;
        ?>        
        <div class='link' route='view_post' idx='<?php echo $post->idx?>'>
            <div class="row">
                <div class="photo">
                    <img src="<?php echo $src?>">
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
                                        <img class='eye' src="<?php echo url_site();?>/theme/default/tmp/eye.png">
                                        <?php echo $post->no_view?>
                                    </div>
                                </td>
                                <td>
                                    <div class="button">
                                        <img class='heart' src="<?php echo url_site();?>/theme/default/tmp/heart.png">
                                        <?php echo $post->no_vote_good?>
                                    </div>
                                </td>
                                <td>
                                    <div class="button">
                                        <img class='reply' src="<?php echo url_site();?>/theme/default/tmp/reply.png">
                                        <?php echo $post->no_comment?>
                                    </div>
                                </td>
                                <td align="right">
                                    <div class="button more">
                                        <img class='more' src="<?php echo url_site();?>/theme/default/tmp/see-more.png">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
