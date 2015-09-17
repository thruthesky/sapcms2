<?php
add_css();
add_javascript();
$comments = post_data()->getComments();
if ( empty($comments) ) return;

?>
<section class="comment-list">
    <?php foreach ( $comments as $comment ) { 	
		$idx_user = $comment['idx_user'];
		if( $idx_user == 0 ) $idx_user = 1;
		$user = user()->load( $idx_user )->fields;
		if( !empty( $user ) ) $name = $user['id'];
		else $name = "Unknown User";

		$primary_photo = data()->loadBy('user', 'primary_photo', $idx_user);
		if( !empty( $primary_photo ) ) $primary_photo = $primary_photo[0]->urlThumbnail(140,140);
	?>
        <div id="comment<?php echo $comment['idx']?>" class="comment" depth="<?php echo $comment['depth']?>">
            <nav class="menu">
               <a class='delete' href="<?php echo url_post_delete($comment['idx'])?>" onclick="return confirmDeletePost('<?php echo "Comment IDX [ ".$comment['idx']." ]"; ?>')"></a>
            </nav>
			<table cellpadding=0 cellspacing=0 width='100%'>
				<tr valign='top'>
				<td width='40'>					
					<?php if( !empty( $primary_photo ) ){?>
						<div class='primary-photo comment-photo'><img src='<?php echo $primary_photo; ?>'/></div>
					<?php } else {?>
						<div class='primary-photo comment-photo temp'></div>
					<?php }?>
				</td>
				<td>
					<div class="content">
						<div class='name'><?php echo $name; ?></div>
						<?php widget('post_view_content', ['post'=>$comment]) ?>
					</div>
				</td>
			</table>
            <?php widget('post_display_files', ['idx'=>$comment['idx']])?>            			                     
			<?php widget('post_view_comment_commands', ['post'=>$comment])?>
			<?php widget('post_view_comment_form', ['post'=>$comment]); ?>			
        </div>
    <?php } ?>
</section>