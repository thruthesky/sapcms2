<?php
	add_css();
	//di( $widget );
	extract( $widget );	
	$comments = post_data()->getComments();
	$total_comments = count( $comments );	
	/*
	$post -> the post
	$comments -> all comments
	*/
	
	//di(  );
	$title = $post['title'];
	$content = $post['content'];
	$date = date("F d, Y",$post['created']);

	if( $post['idx_user'] == 0 ) $user = user()->load( 1 );
	else $user = user()->load( $post['idx_user'] );
	$user_name = $user->fields['name'];
	if( empty( $user_name ) ) $user_name = $user->id;
	
	$post_config = post_config()->load( $post['idx_config'] );
	$pc_name = $post_config->fields['name'];	
?>
<div class='post-view wooreeedu'>
	<div class='inner'>
		<div class='category-title'><?php echo $pc_name; ?></div>
		<div class='title'>
			<?php echo $title; ?>
		</div>
		<div class='post-info'>
			<div class='name'>
				BY <span class='highlight'><?php echo strtoupper( $user_name ); ?></span>
			</div>
			<div class='date'>
				ON <span class='highlight'><?php echo strtoupper( $date ); ?></span>
			</div>
		</div>
		<div class='content'>
			<?php echo $content; ?>
			<?php //widget('post_display_files', ['idx'=>post_data()->getCurrent()->get('idx')]) ?>
			<?php
				$files = data()->loadBy('post', post_data($post['idx'])->config('idx'), $post['idx']);
				$total_files = count( $files );
				?>
				<div class='content-margin'></div>
				<section role="files">
					<div class="display-files">
						<?php 
							display_files_thumbnail( $files, 200, 200 );
						?>
					</div>
				</section>				
		</div>		
	</div>
	<div class='commands post'>
		<?php widget('post_view_wooreeedu_vote', ['post'=>post_data()->getCurrent()->get(), 'show_icons'=>true])?>
		<div class='comments'>
			<img src="/core/module/post/widget/post_view_wooreeedu/img/comment.png">		
			<?php echo $total_comments; ?> Comments
		</div>
		<?php if( login('idx') == $post['idx_user'] ) {?>			
			<a href="<?php echo url_post_delete($post['idx'])?>">Delete</a><!--삭제-->
			<a href="<?php echo url_post_edit($post['idx'])?>">Edit</a><!--수정-->
		<?php } else { ?>
			<a href="/post/report/<?php echo $post['idx'] ?>">Report</a>
		<?php } ?>
	</div>
	
	<?php widget('post_view_wooreeedu_form', ['post'=>post_data()->getCurrent()->get()])?>
	<?php widget('post_view_wooreeedu_comment_list')?>
</div>