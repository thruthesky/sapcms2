<?
add_css();


echo "<div class='post-thumbnail-with-text'>";
	foreach( $posts as $post ){
		$img = $post->getImage();
		$thumbnail = $img->urlThumbnail(100,75);	
		$title = textLengthLimit( $post->title, 30 );
		$thumbnail_label = "<img src='/theme/wooreeedu/img/tempThumbnailLabel.png'/>";
		echo <<<EOH
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
							<div class='label'>$thumbnail_label Wooree</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
EOH;
	}
echo "</div>";
?>
