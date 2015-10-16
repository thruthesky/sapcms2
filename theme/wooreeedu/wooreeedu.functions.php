<?php
function postHoverTitleImage( $posts, $width = 300, $height = 300, $title_length = 30 ){
	echo "<div class='post-hover-title-image'>";
	foreach( $posts as $post ){
		$img = $post->getImage();
		$thumbnail = $img->urlThumbnail($width,$height);
		$title = textLengthLimit( $post->title, 30 );
		$thumbnail_label = "<img src='/theme/wooreeedu/img/tempThumbnailLabel.png'/>";
		$url = $post->url();
		
		echo <<<EOH
		<a href=$url>
			<div class='item'>
				<img class='thumbnail' src='$thumbnail'/>
				<div class='title'>
					<div class='text'>$title</div>
					<div class='label'>$thumbnail_label Category...?</div>
				</div>
			</div>
		</a>
EOH;
	}
	echo "</div>";
}

function postThumbnailWithText( $posts, $width = 100, $height = 100, $title_length = 30 ){
echo "<div class='post-thumbnail-with-text'>";
	foreach( $posts as $post ){
		$img = $post->getImage();
		$thumbnail = $img->urlThumbnail($width,$height);	
		$title = textLengthLimit( $post->title, $title_length );
		$thumbnail_label = "<img src='/theme/wooreeedu/img/tempThumbnailLabel.png'/>";
		$url = $post->url();
		$post_config = post_config()->load( $post->idx_config );
		$post_config_id = $post_config->id;
		
		echo <<<EOH
		<a href=$url>
			<div class='item'>
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
								<div class='label'>$thumbnail_label $post_config_id</div>
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
echo "<div class='post-bullet-list'>";
	$thumbnail_label = "<img src='/theme/wooreeedu/img/tempThumbnailLabel.png'/>";
	foreach( $posts as $post ){
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