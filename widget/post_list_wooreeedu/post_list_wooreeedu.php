<?php
add_css();
$posts = post()->postListData();	

//url_post_view( $post )
//date_short

$post_config = post_config()->getCurrent();
$pc_name = $post_config->fields['name'];
?>
<div class="post-list wooreeedu">		
		<div class='category-title'>
			<?php echo $pc_name; ?>
			<?php widget('post_list_menu'); ?>
		</div>		
        <?php foreach( $posts as $post ) { 
			$title = $post['title'];
			$content = strcut( $post['content'], 200 )."...";
			$date = date("F d, Y",$post['created']);

			if( $post['idx_user'] == 0 ) $user = user()->load( 1 );
			else $user = user()->load( $post['idx_user'] );
			$user_name = $user->fields['name'];
			if( empty( $user_name ) ) $user_name = $user->id;
			
			$url = url_post_view( $post );
		?>
			<div class='inner'>				
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
				</div>
				<a href='<?php echo $url; ?>' class='read-more'>
					자세히 보기
					<div class='arrow right'></div>
				</a>
			</div>			
        <?php } ?>		
		<div class='page-navigator-wrapper clearfix'>
			<?php widget('post_list_search_box_wooreeedu', $widget); ?>
			<?php widget('post_list_navigator'); ?>			
		</div>		
</div>

