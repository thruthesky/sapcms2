<?php
namespace sap\post;


use sap\src\Entity;

class PostData extends Entity {

    private static $current = null;

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
        $options['idx_config'] = $config->get('idx');
        $options['idx_user'] = login('idx');
        $options['title'] = request('title');
        $options['content'] = request('content');
        return PostData::newPost($options);
    }


    /**
     *
     * If there is no current data, then returns FALSE.
     *
     * @Attention it search the current data
     *
     *      - Firstly, if request('idx') is available.
     *      - Secondly, if self::$current is set by setCurrent().
     *
     * @return $this|bool
     */
    public function getCurrent() {
        if ( $idx = request('idx') ) {
            return $this->load($idx);
        }
        else if ( self::$current ) {
            return self::$current;
        }
        else return FALSE;
    }

    public static function setCurrent(PostData & $data) {
        self::$current = $data;
    }


    /**
     *
     *
     * @Attention It create a new post and sets to current data.
     *
     * @param array $options
     * @return $this|bool|PostData
     */
    public static function newPost(array &$options) {
        $data = post_data();
        $data->set($options);
        $data->set('delete', 0);
        $data->set('block', 0);
        $data->set('blind', 0);
        $data->set('report', 0);
        $data->set('content_stripped', strip_tags($options['content']));
        $data->set('ip', ip());
        if ( ! isset($options['domain']) ) $data->set('domain', domain());
        if ( ! isset($options['user_agent']) ) $data->set('domain', user_agent());
        $data->save();
        self::setCurrent($data);
        return $data;
    }



}
