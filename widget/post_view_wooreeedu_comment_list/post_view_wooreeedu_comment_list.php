<?php
add_css();
add_javascript();
$comments = post_data()->getComments();
if ( empty($comments) ) return;

//$user_idx = login('idx');



?>
<div class="comment-list">
    <?php foreach ( $comments as $comment ) { 
		if( $comment['delete'] != 0 ) $content = "This post is deleted";
		else $content = $comment['content'];
		
		$date = date("d M Y", $comment['created']);
		
		$user_idx = $comment['idx_user'];
		if( empty( $user_idx ) ){
			$user_idx = 0;
			$user_name = "Anonymous";	
		}
		else{	
			$user = user()->load( $user_idx );
			$user_name = $user->name;	
			if( empty( $user_name ) ) $user_name = $user->id;
			$user_photo = data()->loadBy('user', 'primary_photo', 0, $user_idx);
			if( !empty( $user_photo ) ) $user_photo = $user_photo[0]->urlThumbnail(100,100);
		}

		if( empty( $user_photo ) ) $user_photo = "/widget/post_view_wooreeedu_form/img/no_primary_photo.png";
	?>
        <div id="comment<?php echo $comment['idx']?>" class="comment" depth="<?php echo $comment['depth']?>">
            <table cellpadding=0 cellspacing=0 width='100%'>
				<tr valign='top'>
					<td width='90'>
						<div class='primary-photo'>
							<img src='<?php echo $user_photo; ?>'/>
						</div>
					</td>
					<td width='99%'>					
					<div class="content">
						<div class='name'><?php echo $user_name; ?></div>
						<?php echo $content; ?>
						<?php
							$files = data()->loadBy('post', post_data($comment['idx'])->config('idx'), $comment['idx']);
							$total_files = count( $files );
						?>
						<div class='content-margin'></div>
						<div role="files">
							<div class="display-files">
								<?php 
									display_files_thumbnail( $files, 200, 200 );
								?>
							</div>
						</div>
					</div>
					<?php //widget('post_display_files', ['idx'=>$comment['idx']])?>
						
					<div class='commands comment'>
						<?php widget('post_view_wooreeedu_vote', ['post'=>$comment])?>
						<div class="reply-button">Reply</div>
						<?php if( $user_idx == $comment['idx_user'] || login('id') == 'admin' ) {?>
							<a href="<?php echo url_post_comment_edit($comment['idx'])?>">수정</a><!--수정-->
							<a class='post-delete' href="<?php echo url_post_delete($comment['idx'])?>">삭제</a><!--삭제-->
						<?php } else { ?>
							<a href="#">Report</a>
						<?php } ?>
						<div class='date'><?php echo $date ?></div>
					</div>
					</td>
				</tr>
			</table>    						
			<?php widget('post_view_wooreeedu_form', ['post'=>$comment])?>
            <?php //widget('post_view_comment_form', ['post'=>$comment]); ?>
        </div>
    <?php } ?>
</div>