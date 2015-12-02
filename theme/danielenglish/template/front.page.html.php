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
	<a class='left-wing test' href='http://danielenglish.begin.kr/solution' target="_blank"><img src="/theme/danielenglish/img/class/ve_test.jpg"></a>
	<span class='left-wing bank'><img src="/theme/danielenglish/img/class/bank.png"></span>
	<div class='grid first'>
		<div class='a'>
			<a href="http://pineseg.com/pinesjr/event_camp.html" target="_blank"><img class='front-banner' src="/theme/danielenglish/img/class/main-banner-left.jpg"></a>
			<div class='floater-dotted'>
				<a class='text' href='/post/list?id=story'>수업후기</a>
			</div>
			<?php
				$posts = getPostWithImageNoComment(0, 3, 'qna');			
				if( !empty( $posts[0] ) ) echo postBannerWithText( $posts[0], 520, 500, 20, 200 );
				
				$post_items = array_slice( $posts, 1, 2 );
				if( !empty( $posts ) ) echo postThumbnailWithText( $post_items, 'long-version', 100, 75, 100 );
			?>
		</div>
		<div class='b'>
			<div class='grid second'>
				<a class='front-banner' href='http://www.kindertimes.co.kr/'><img src="/theme/danielenglish/img/class/smallBanner1.png"></a><a class='front-banner'  href='http://www.kidstimes.net/'>
				<img src="/theme/danielenglish/img/class/smallBanner2.png"></a><a class='front-banner'  href='http://www.teentimes.org/'>
				<img src="/theme/danielenglish/img/class/smallBanner3.png"></a>
				<div class='floater-bar'>
					<a class='text' href='/post/list?id=qna'>질문과 답변</a>
				</div>
				<div class='a'>							
					<?php
						$posts = getPostWithImageNoComment(0, 8, 'story');
						$post_items = array_slice( $posts, 0, 1 );				
						if( !empty( $posts[0] ) ) echo postHoverTitleImage( $post_items, 444, 334, 30 );
						
						$post_items = array_slice( $posts, 1, 3 );
						if( !empty( $post_items ) ) echo postThumbnailWithText( $post_items, null, 100, 75, 30 );
					?>
				</div>
				<div class='b'>
					<?php 
						$post_items = array_slice( $posts, 4, 1 );
						echo postHoverTitleImage( $post_items, 444, 334, 30 );
						
						$post_items = array_slice( $posts, 5, 3 );
						echo postThumbnailWithText( $post_items, null, 100, 75, 30 );
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<iframe src="http://danielenglish.begin.kr/iframe_login.php?id=<?php echo login('id')?>&classid=solution&page=teacher_list" width="100%" height="2400" style="border:0; box-sizing:border-box;"></iframe>

<!--[if lte IE 8]>
<style>
/*front page*/
	.page-content.top .left-wing{	
		display:block;
	}
	
	.front-top-banner .arrow{
		
	}
	
	.front-top-banner:hover .arrow{
		padding:0;
	}
	
	.front-top-banner:hover .arrow .original{
		display:none;
	}
	
	.front-top-banner:hover .arrow .ie8{
		display:block;
		width:75px;
	}
	
	/*front banner text*/
	.front-top-banner .banner-wrapper .text-info{
		display:block;
	}
	
	.front-top-banner .one.banner-wrapper .text-info > .inner .bottom.text, 
	.front-top-banner .three.banner-wrapper .text-info > .inner .bottom.text, 
	.front-top-banner .five.banner-wrapper .text-info > .inner .bottom.text{
		background-color:#fff;
	}
	
	.front-top-banner .two.banner-wrapper .text-info{
		margin-top:20px;
	}
	
	.front-top-banner .two.banner-wrapper .text-info > .inner .text-items{
		position:relative;				
	}
	
	.front-top-banner .two.banner-wrapper .text-info > .inner .top.text{
		text-align:left;
		font-size:1.4em;
		padding:20px 20px 10px 20px;
	}
	
	.front-top-banner .two.banner-wrapper .text-info > .inner .text-items .bottom.text{
		display:block;
	}
	
	.front-top-banner .two.banner-wrapper .text-info > .inner .more.text{
		position:relative;
		padding:10px 20px 20px 20px;
		text-align:left;
	}
	
	.front-top-banner .two.banner-wrapper .text-info > .inner > .wrapper, 
	.front-top-banner .four.banner-wrapper .text-info > .inner > .wrapper{
		width:250px;
		background-color:#000;
	}
	
	.front-top-banner .two.banner-wrapper .text-info > .inner > .wrapper .fake-image{
		display:none;
	}
	/*eo front banner text*/
	
	/*middle items*/
	.top.page-content .floater-bar{
		height:34px;		
	}
	
	.top.page-content .floater-bar .text{
		padding:5px 18px 5px 18px;
	}
	
	.grid.second > .a, .grid.second > .b{
		width:50%;
	}	

	.grid.second > .b{
		display:block;
	}	
	/*eo middle items*/
/*eo front page*/
</style>
<![endif]-->
