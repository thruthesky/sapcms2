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
	<a class='left-wing ve' href='<?php echo $url_ve ?>'><img src="/theme/englishworld/img/left_wing_ve.png"></a>
	<a class='left-wing team-viewer' href='/theme/teamviewer.exe' download><img src="/theme/englishworld/img/left_wing_team_viewer.png"></a>
	<a class='left-wing test' href='http://englishworld.begin.kr/solution' target="_blank"><img src="/theme/englishworld/img/class/ve_test.jpg"></a>
	<div class='grid first'>
		<div class='a'>
			<a href="http://pineseg.com/pinesjr/event_camp.html" target="_blank"><img class='front-banner' src="/theme/englishworld/img/class/main-banner-left.jpg"></a>
			<div class='floater-dotted'>
				<a class='text' href='/post/list?id=wooreeedu'>수업후기</a>
			</div>
			<?php
				$posts = getPostWithImageNoComment(0, 3, 'wooreeedu');			
				if( !empty( $posts[0] ) ) echo postBannerWithText( $posts[0], 520, 500, 20, 200 );
				
				$post_items = array_slice( $posts, 1, 2 );
				if( !empty( $posts ) ) echo postThumbnailWithText( $post_items, 'long-version', 100, 75, 100 );
			?>
		</div>
		<div class='b'>
			<div class='grid second'>
				<a class='front-banner' href='http://www.kindertimes.co.kr/'><img src="/theme/englishworld/img/class/smallBanner1.png"></a><a class='front-banner'  href='http://www.kidstimes.net/'>
				<img src="/theme/englishworld/img/class/smallBanner2.png"></a><a class='front-banner'  href='http://www.teentimes.org/'>
				<img src="/theme/englishworld/img/class/smallBanner3.png"></a>
				<div class='floater-bar'>
					<a class='text' href='/post/list?id=wooreeedu_gallery'>질문과 답변</a>
				</div>
				<div class='a'>							
					<?php
						$posts = getPostWithImageNoComment(0, 8, 'wooreeedu_gallery');
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
<iframe src="http://wooreeedu.begin.kr/iframe_login.php?id=<?php echo login('id')?>&classid=solution&page=teacher_list" width="100%" height="2400" style="border:0; box-sizing:border-box;"></iframe>

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
	.front-top-banner .banner-wrapper{
		/*z-index:-2;*/
	}
	
	.front-top-banner .banner-wrapper img.front-fake{
		/*z-index:-1;*/
	}
	
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
	
	.front-top-banner .banner-wrapper.four .text-info > .inner .text.more{
		width:90%!important;
		padding-left:5%;
		padding-right:5%;
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
	
	/*top banner*/
	.front-top-banner .banner-wrapper .text-info > .inner .text{
		display:inline;
	}
	/*eo top banner*/
	
	/*sub menu banner*/
	#header-top > .inner .sub-menu{
		z-index:100000!important;
	}
	
	.featuredPost .item{
		position:absolute;
		left:0;
		top:0;
	}
	

	.front-fake-featured{
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";	
		filter: alpha(opacity=0);
	}
	/*eo sub menu banner*/
	
	.post-banner-with-text .item{
		height:270px;
	}
/*eo front page*/
</style>
<![endif]-->
