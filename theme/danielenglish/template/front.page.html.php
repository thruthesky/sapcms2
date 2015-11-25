<?php
/*
Do not forget to change the post queries
*/
add_css();
add_css('front.postThumbnailWithText.css');
add_css('front.postHoverTitleImage.css');
add_css('front.postBulletList.css');
add_css('front.postBannerWithText.css');
?>
<div class='page-content top'>
	<a class='left-wing ve' href='/ve?page=solution'><img src="/theme/danielenglish/img/left_wing_ve.png"></a>
	<a class='left-wing team-viewer' href='/theme/teamviewer.exe' download><img src="/theme/danielenglish/img/left_wing_team_viewer.png"></a>
	<section class='grid first'>
		<div class='a'>
			<a href="http://pineseg.com/pinesjr/event_camp.html" target="_blank"><img class='front-banner' src="/theme/danielenglish/img/class/main-banner-left.jpg"></a>
			<div class='floater-dotted'>
				<a class='text' href='/post/list?id=story'>수업후기</a>
			</div>
			<?php
				$posts = getPostWithImageNoComment(0, 3, 'story');			
				if( !empty( $posts[0] ) ) echo postBannerWithText( $posts[0], 520, 500, 20, 200 );
				
				$post_items = array_slice( $posts, 1, 2 );
				if( !empty( $posts ) ) echo postThumbnailWithText( $post_items, 'long-version', 100, 75, 100 );
			?>
		</div>
		<div class='b'>
			<section class='grid second'>
				<a class='front-banner' href='http://www.kindertimes.co.kr/'><img src="/theme/danielenglish/img/class/smallBanner1.png"></a><a class='front-banner'  href='http://www.kidstimes.net/'>
				<img src="/theme/danielenglish/img/class/smallBanner2.png"></a><a class='front-banner'  href='http://www.teentimes.org/'>
				<img src="/theme/danielenglish/img/class/smallBanner3.png"></a>
				<div class='floater-bar'>
					<a class='text' href='/post/list?id=qna'>질문과 답변</a>
				</div>
				<div class='a'>							
					<?php
						$posts = getPostWithImageNoComment(0, 8, 'qna');
						$post_items_1 = array_slice( $posts, 0, 1 );				
						if( !empty( $posts[0] ) ) echo postHoverTitleImage( $post_items_1, 444, 334, 30 );
						
						$post_items_2 = array_slice( $posts, 1, 3 );
						if( !empty( $post_items ) ) echo postThumbnailWithText( $post_items_2, null, 100, 75, 30 );
					?>
				</div>
				<div class='b'>
					<?php 
						$post_items_3 = array_slice( $posts, 4, 1 );
						echo postHoverTitleImage( $post_items_3, 444, 334, 30 );
						
						$post_items_4 = array_slice( $posts, 5, 3 );
						echo postThumbnailWithText( $post_items_4, null, 100, 75, 30 );
					?>
				</div>
			<section>
		</div>
	</section>
</div>
<iframe src="http://danielenglish.begin.kr/iframe_login.php?id=<?php echo login('id')?>&classid=solution&page=teacher_list" width="100%" height="2400" style="border:0; box-sizing:border-box;"></iframe>
