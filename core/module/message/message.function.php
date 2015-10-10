<?php

use sap\core\message;
	
	//display_files uses post.function.php...
	
	function display_files_thumbnail( $files, $height = 200, $width = 200, $limit = 0 ) {
		if ( empty($files) ) return null;	
		$tag_imgs = [];
		$tag_files = [];
		//foreach($files as $file) {
		if( $limit == 0 ) $limit = count( $files );	
		for( $i = 0; $i < $limit; $i ++ ){
			$file = $files[$i];		
			$url = $file->urlThumbnail( $width, $height );
			$name = $file->get('name');
			if ( is_image($name) ) {
				$tag_imgs[] = "<div class='image' idx='".$file->idx."'><img src='$url'></div>";
			}
			else {
				$tag_files[] = "<div class='attachment'><a href='$url'>$name</a></div>";
			}
		}
		
		echo "<div class='attachments'>";
		array_walk($tag_files, 'display');
		echo "</div>";
		echo "<div class='images clearfix'>";
		array_walk($tag_imgs, 'display');
		echo "</div>";
	}