<?php

use sap\core\post\post;
use sap\core\post\PostConfig;
use sap\core\post\PostData;
use sap\core\post\PostVoteHistory;
use sap\src\Route;

/**
 *
 * Returns an Item of PostConfig Entity.
 *
 *
 *
 *
 * @param null $field - is the field name
 *
 * @param null $value
 * @return PostConfig|bool
 */
function post_config($field=null, $value=null) {
    if ( $field && $value ) {
        return post_config()->load($field, $value);
    }
    else if ( $field ) {
        if ( is_numeric($field) ) return post_config()->load('idx', $field);
        else return post_config()->load('id', $field);
    }
    else return new PostConfig();
}




function post_data($idx=null) {
    if ( $idx ) {
        return post_data()->load('idx', $idx);
    }
    return new PostData();
}

function post() {
    return new post();
}


function post_vote_history() {
    return new PostVoteHistory();
}





function is_post_page() {
    return segment(0) == 'post';
}
function is_post_config_page() {
    return segment(1) == 'config';
}

function is_post_edit_page() {
    return segment(1) == 'edit' || segment(2) == 'edit';
}



function url_post_edit() {
    return post::urlPostEdit();
}
function url_post_create() {
    return post::urlPostCreate();
}
function url_post_config() {
    return post::urlEditPostConfig();
}
function url_post_list($id=null, $add_vars=true) {
    return post::urlPostList($id,$add_vars);
}

function url_post_view($post) {
    return post::urlPostView($post);
}

function html_hidden_post_variables() {
    return post::getHttpVariablesAsHidden();
}
function url_post_comment_edit($idx) {
    return post::urlPostCommentEdit($idx);
}
function url_post_delete($idx=0) {
    return post::urlPostDelete($idx);
}

function display_files_thumbnail( $files, $height, $width, $limit = 0 ) {			
		if ( empty($files) ) return null;	
		$tag_imgs = [];
		$tag_files = [];
		foreach($files as $file) {		
		//$total_files = count( $files );
		//if( $limit == 0 ) $limit = $total_files;
		//for( $i = 0; $i < $limit; $i ++ ){
			//$file = $files[$i];				
			$name = $file->get('name_saved');
			if ( is_image($name) ) {				
				/*
				$more_image = null;
				$more_image
				if( $i >= 3 ){					
					if( $total_files > $limit ) $more_image = "<div class='more-images'>+".( $total_files - $limit )."</div>";										
				}
				*/	
				$url = $file->urlThumbnail( $width, $height );				
				$tag_imgs[] = "<div class='image modal-image' idx='".$file->idx."'><img src='$url'></div>";
			}
			else {
				$url = $file->url();
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

function display_files($files) {
    if ( empty($files) ) return null;
    $tag_imgs = [];
    $tag_files = [];
    foreach($files as $file) {
        $url = $file->url();
        $name = $file->get('name_saved');
        if ( is_image($name) ) {
            $tag_imgs[] = "<div class='image'  idx='".$file->idx."'><img src='$url'></div>";
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


function is_post_admin() {
    if ( admin() ) return true;
    return false;
}

/**
 *
 * Returns true if the post is login user's post.
 *
 * @param $idx
 * @return bool
 * @code
 * $idx = request('idx');
 * if ( is_my_post($idx) ) { ... }
 *
 * $data = post_data($idx);
 * if ( ! is_my_post($data) ) return self::templateErrorNotYourPost();
 * @endcode
 */
function is_my_post($idx) {
    if ( is_numeric($idx) ) $post = post_data($idx);
    else if ( $idx instanceof PostData ) $post = $idx;
	
	//added by benjamin for admin
	if( login('id') == 'admin' ) return true;
	
    if ( $post ) {
        return $post->get('idx_user') == my('idx');
    }
    return false;
}


function url_forum() {
    return "/post";
}

/*
*Added by benjamin
*/

//need to add query..........
function getPostWithImage($index,$limit,$postConfig){
	$images = post()->getLatestPostImages($index, $limit, $postConfig);
	$posts = [];
	if ( $images ) {
		foreach ( $images as $image ) {
			$item = post_data()->load( $image->idx_target );
			$posts[] = $item;
		}
	}
	return $posts;
}

/*
*added by benjamin without using joins for table
*/
function getPostWithImageNoComment($index,$limit,$postConfig){
	$images = post()->getLatestPostImages($index, $limit, $postConfig);
	$posts = [];
	if ( $images ) {
		foreach ( $images as $image ) {
			$item = post_data()->load( $image->idx_target );			
			if( $item->idx_parent == 0 ) $posts[] = $item;
		}
	}
	
	$stop_at = $limit;	
	if( count( $posts ) < $limit ){
		$continue_loop = true;
		while( $continue_loop ){
			$images = post()->getLatestPostImages($stop_at, ( $stop_at + 1 ), $postConfig);
			$stop_at = $stop_at + 1;
			if( !empty( $images ) ){
				$image = $images[0];
				$item = post_data()->load( $image->idx_target );
				if( $item->idx_parent == 0 ) $posts[] = $item;
				
				if( count( $posts ) >= $limit ) $continue_loop = false;
			}
			else $continue_loop = false;
		}
	}
	return $posts;
}


function textLengthLimit( $text, $length = 30 ){	
	if( !empty ( $text ) ){
		if( strlen( $text ) > $length ){
			$text = substr( $text, 0, $length )."...";
		}
	}
	
	return $text;
}




