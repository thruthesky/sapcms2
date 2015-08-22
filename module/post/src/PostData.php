<?php
namespace sap\post;


use sap\src\Entity;

class PostData extends Entity {
    public function __construct() {
        parent::__construct(POST_DATA);
    }


    /**
     *
     * Pre-process for post(s)
     *
     * @param $posts
     * @return array
     */
    public static function preProcess($posts)
    {
        if ( empty($posts) ) return FALSE;
        if ( $posts instanceof PostData ) {
            $post = $posts->getFields();
            $post = self::pre($post);
            return $post;
        }
        $new_posts = [];
        foreach ( $posts as $post ) {
            $new_posts[] = self::pre($post);
        }
        return $new_posts;
    }

    /**
     * Pre-process A post
     * @param array $post
     * @return array
     */
    public static function pre(array & $post) {
        $post['title'] = self::getTitleOrContent($post);
        $post['url'] = "/post/view?$post[title]&idx=$post[idx]";

        if ( $post['idx_user'] ) {
            $post['user'] = user($post['idx_user']);
        }
        else $post['user'] = FALSE;
        return $post;
    }

    /**
     *
     *
     *
     * @param array $post
     * @return null|string
     */
    private static function getTitleOrContent(array & $post)
    {
        if ( ! empty($post['title']) ) return $post['title'];
        else if ( ! empty($post['content']) ) return strcut($post['content'], 128);
        else return null;
    }

    /**
     *
     * If there is no current data, then returns FALSE.
     *
     * @return $this|bool
     */
    public function getCurrent() {
        if ( $idx = request('idx') ) {
            return $this->load($idx);
        }
        else return FALSE;
    }
}
