<?php
namespace sap\post;


use sap\src\Entity;

class PostData extends Entity {
    public function __construct() {
        parent::__construct(POST_DATA);
    }


    /**
     *
     * Pre-process single post
     *
     * @param $post
     * @return array
     */
    public static function preProcess($post)
    {
        if ( empty($post) ) return FALSE;
        if ( $post instanceof PostData ) {
            $post = $post->getFields();
        }
        $post = self::pre($post);
        return $post;
    }

    /**
     * Pre-process multi posts.
     * @param $posts
     * @return array
     */
    public static function multiPreProcess($posts) {
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

        $post['url'] = post::getViewUrl($post);
        if ( $post['idx_user'] ) {
            $post['user'] = user($post['idx_user'])->getFields();
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

    public static function formSubmit()
    {
        $config = post_config()->getCurrent();
        $data = post_data();
        $data->set('idx_config', $config->get('idx'));
        $data->set('idx_user', login('idx'));
        $data->set('title', request('title'));
        $data->set('content', request('content'));
        $data->save();
        return $data;
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
