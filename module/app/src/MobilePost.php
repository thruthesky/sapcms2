<?php
namespace sap\app;
class MobilePost {
    public static function postList($post_id) {
        $posts = post()->postListWithComment(['id' => $post_id]);
		//di( $posts );exit;
        $postsWithComment = [];
        foreach ( $posts as $post ) {
            //$post['comments'] = post_data($post['idx'])->getComments();			
			//$src = post_data($post['idx'])->getImage()->urlThumbnail(400,140);	
			//$files = data()->loadBy('post', post_data($post['idx'])->config('idx'), $post['idx']);
			//if( !empty( $files ) ) $post['files'] = $files;			
            $postsWithComment[] = $post;
        }
		//di( $postsWithComment );exit;
        return $posts;
    }
}
