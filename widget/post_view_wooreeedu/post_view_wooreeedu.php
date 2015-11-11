<?php
	add_css();
	add_javascript();
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
	if( $post['delete'] != 0 ) $content = "This post is deleted";
	else $content = $post['content'];

	$date = date("F d, Y",$post['created']);

	if( $post['idx_user'] == 0 ) $user = user()->load( 1 );
	else $user = user()->load( $post['idx_user'] );
	$user_name = $user->fields['name'];
	if( empty( $user_name ) ) $user_name = $user->id;
	
	$post_config = post_config()->load( $post['idx_config'] );
	$pc_name = $post_config->fields['name'];	
	$pc_url = "/post/list?id=".$post_config->id;
?>
<div class='post-view wooreeedu'>
	<div class='inner'>
		<div class='category-title'>
			<a href='<?php echo $pc_url; ?>'><?php echo $pc_name; ?></a>
			<a class='post-list' href='<?php echo $pc_url; ?>'>목록</a>
		</div>
		<div class='title'>
			<?php echo $title; ?>
		</div>
		<div class='post-info'>
			<div class='name'>
				글쓴이 <span class='highlight'><?php echo strtoupper( $user_name ); ?></span>
			</div>
			<div class='date'>
				날짜 <span class='highlight'><?php echo strtoupper( $date ); ?></span>
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
			<img src="/widget/post_view_wooreeedu/img/comment.png">		
			<?php echo $total_comments; ?> Comment<?php echo $total_comments > 1 ? "s":"" ?>
		</div>
		<?php if( login('idx') == $post['idx_user'] || login('id') == 'admin' ) {?>			
			<a class='post-delete' href="<?php echo url_post_delete($post['idx'])?>">삭제</a><!--삭제-->
			<a href="<?php echo url_post_edit($post['idx'])?>">수정</a><!--수정-->
		<?php } else { ?>
			<a href="/post/report/<?php echo $post['idx'] ?>">신고</a>
		<?php } ?>
	</div>
	
	<?php widget('post_view_wooreeedu_form', ['post'=>post_data()->getCurrent()->get()])?>
	<?php widget('post_view_wooreeedu_comment_list')?>
</div>