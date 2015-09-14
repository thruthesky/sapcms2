<?php
namespace sap\bird;
class MobilePost {
    public static function postList($post_id) {
        $posts = post()->postListWithComment(['id' => $post_id]);
        $postsWithComment = [];
        foreach ( $posts as $post ) {
            $post['comments'] = post_data($post['idx'])->getComments();
            $postsWithComment[] = $post;
        }
        return $posts;
    }
}
