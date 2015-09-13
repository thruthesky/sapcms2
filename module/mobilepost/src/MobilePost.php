<?php
namespace sap\mobilepost;

use sap\src\Response;

class MobilePost {
    public static function postList($post_id) {
        $posts = post()->postListWithComment(['id' => $post_id]);
        $post_body = null;
        foreach ( $posts as $post ) {
            $post_body .= "$post[title]<br>";
        }
        return $post_body;
    }
}
