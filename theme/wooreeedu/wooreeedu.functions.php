<?php
function postHoverTitleImage( $posts, $width = 300, $height = 300, $title_length = 30 ){
	if( empty( $posts ) ) return null;
	echo "<div class='post-hover-title-image'>";
	foreach( $posts as $post ){
		if( empty( $post ) ) continue;
		$img = $post->getImage();
		$thumbnail = $img->urlThumbnail($width,$height);
		$title = textLengthLimit( $post->title, 30 );
		$thumbnail_label = "<img src='/theme/wooreeedu/img/tempThumbnailLabel.png'/>";
		$url = $post->url();
		$post_config = post_config()->load( $post->idx_config );
		$post_config_id = $post_config->id;
		
		echo <<<EOH
		<a href=$url>
			<div class='item'>
				<img class='thumbnail' src='$thumbnail'/>
				<div class='title'>
					<div class='text'>$title</div>
					<div class='label'>$thumbnail_label $post_config_id</div>
				</div>
			</div>
		</a>
EOH;
	}
	echo "</div>";
}

function postThumbnailWithText( $posts, $extra_class = null, $width = 100, $height = 100, $title_length = 30 ){
if( empty( $posts ) ) return null;
echo "<div class='post-thumbnail-with-text'>";
	foreach( $posts as $post ){
		if( empty( $post ) ) continue;
		$img = $post->getImage();
		$thumbnail = $img->urlThumbnail($width,$height);	
		$title = textLengthLimit( $post->title, $title_length );
		$content = textLengthLimit( strip_tags( $post->content ), $title_length );
		$thumbnail_label = "<img src='/theme/wooreeedu/img/tempThumbnailLabel.png'/>";
		$url = $post->url();
		$post_config = post_config()->load( $post->idx_config );
		$post_config_name = $post_config->name;

		$no_views = $post->no_view;
		$no_comment = $post->no_comment;
		$no_good = $post->no_good;
		$date = date( "M d, Y", $post->created );
		if( empty( $no_good ) ) $no_good = 0;
		//<div class='extra'><img src='/module/app/img/comment.png'/> $no_comment <span class='separator'></span> <img src='/module/app/img/like.png'/> $no_good <span class='separator'></span> $date</div>
		echo <<<EOH
		<a href=$url>
			<div class='item $extra_class'>
				<table cellpadding=0 cellspacing=0 width='100%'>
					<tr valign='top'>
						<td>
							<div class='photo-wrapper'>
								<img src='$thumbnail'/>
							</div>
						</td>
						<td width='99%'>
							<div class='info'>
								<div class='title'>$title</div>
								<div class='content'>$content</div>
								<div class='label'>$thumbnail_label $post_config_name</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</a>
EOH;
	}
echo "</div>";
}

function postBulletList( $posts, $title_length = 30 ){
if( empty( $posts ) ) return null;
echo "<div class='post-bullet-list'>";
	$thumbnail_label = "<img src='/theme/wooreeedu/img/tempThumbnailLabel.png'/>";
	foreach( $posts as $post ){
		if( empty( $post ) ) continue;
		$url = $post->url();
		$title = textLengthLimit( $post->title, $title_length );
		echo <<<EOH
		<a href=$url>
			<div class='item'>			
				<div class='title'>
					$title $thumbnail_label
				</div>
			</div>
		</a>
EOH;
	}
	echo "</div>";
}

function postBannerWithText( $post, $width = 200, $height = 200, $title_length = 30, $content_length = 100 ){
if( empty( $post ) ) return null;
	echo "<div class='post-banner-with-text'>";
	$img = $post->getImage();
	$thumbnail = $img->urlThumbnail($width,$height);	
	$title = textLengthLimit( $post->title, $title_length );
	$content = textLengthLimit( $post->content, $content_length );
	$url = $post->url();
	
	echo <<<EOH
	<a href=$url>
		<div class='item clearfix'>			
			<div class='photo-wrapper'>
				<img src='$thumbnail'/>
			</div>
			<div class='info'>
				<div class='title'>$title</div>
				<div class='content'>$content</div>
			</div>
		</div>
	</a>
EOH;

	echo "</div>";
}
/*
function getFrontTopBannerImages( $posts, $width = 1280, $height = 400 ){
	if( empty( $posts ) ) return null;
	$total_banners = count( $posts );
	if( $total_banners > 1 ){
		$img = $posts[ ( $total_banners -1 )]->getImage();
		$thumbnail = $img->urlThumbnail($width,$height);
		echo "<img class='banner fake' src='$thumbnail'>";
	}
	foreach( $posts as $post ){
		$img = $post->getImage();
		$thumbnail = $img->urlThumbnail($width,$height);
		echo "<img class='banner' src='$thumbnail'>";
	}
	if( $total_banners > 1 ){
		$img = $posts[0]->getImage();
		$thumbnail = $img->urlThumbnail($width,$height);
		echo "<img class='banner fake' src='$thumbnail'>";
	}
}
*/
/*
function postFeaturedSlider( $posts, $width = 200, $height = 150, $subject_length = 20 ){
	$total_posts = count($posts);
	if( !empty( $posts ) ) {
		echo "<div class='featuredPost'>";
		
		echo "<div class='page-navigator'>";
		for( $i = 1; $i<=$total_posts; $i++ ){
			if( $i == 1 ) $is_active = ' is-active';
			else $is_active = null;
			echo "<div class='page-item$is_active' page='$i'></div>";
		}
		echo "</div>";
		
		echo "<div class='inner'>";
		
		echo "<div class='item fake'><img src='theme/wooreeedu/img/popsong_5.jpg'/><div class='title text-center'>Title 5</div></div>";
				
		for( $i= 1; $i <= 5; $i++ ){
			$url = "theme/wooreeedu/img/popsong_$i.jpg";
			echo "<div class='item'><img src='$url'/><div class='title text-center'>Title $i</div></div>";
		}
			echo "<div class='item fake'><img src='theme/wooreeedu/img/popsong_1.jpg'/><div class='title text-center'>Title 1</div></div>";
	
		echo "</div></div>";
	}
}
*/