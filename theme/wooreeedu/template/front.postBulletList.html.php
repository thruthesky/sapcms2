<?php
add_css();
echo "<div class='post-bullet-list'>";
$thumbnail_label = "<img src='/theme/wooreeedu/img/tempThumbnailLabel.png'/>";
foreach( $posts as $post ){
		$title = textLengthLimit( $post->title, 20 );
		echo <<<EOH
		<div class='item'>			
			<div class='title'>
				$title $thumbnail_label
			</div>
		</div>
EOH;
}
echo "</div>";
?>