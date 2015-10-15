<?php
add_css();
echo "<div class='post-hover-title-image'>";
	foreach( $posts as $post ){
		$img = $post->getImage();
		$thumbnail = $img->urlThumbnail(465,364);
		$title = textLengthLimit( $post->title, 30 );
		$thumbnail_label = "<img src='/theme/wooreeedu/img/tempThumbnailLabel.png'/>";
		echo <<<EOH
		<div class='item'>
			<img class='thumbnail' src='$thumbnail'/>
			<div class='title'>
				<div class='text'>$title</div>
				<div class='label'>$thumbnail_label Wooree</div>
			</div>
		</div>
EOH;
	}
	echo "</div>";
?>
