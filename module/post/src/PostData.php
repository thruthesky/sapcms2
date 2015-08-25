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

        if ( $post['idx_parent'] ) $post['url'] = post::getViewCommentUrl($post['idx']);
        else $post['url'] = post::getViewUrl($post);
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
        if ( post::isNewPostSubmit() ) {

        }
        else if ( post::isNewComment() ) {
            $options['idx_root'] = post_data(request('idx_parent'))->get('idx_root');
            $options['idx_parent'] = request('idx_parent');
        }
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
     * Returns comments.
     *
     *
     * @param $idx
     *      - is the original post whose idx_parent is 0
     *      - If it is set to 0, then it returns the comments of current post.
     * @return mixed
     */
    public function getComments($idx=0) {
        if ( empty($idx) ) {
            $data = post_data()->getCurrent();
        }
        else {
            $data = post_data($idx);
        }
        if ( empty($data) ) return setError(-50340, "Cannot find original post");
        if ( $data->get('idx_parent') ) return setError(-50341, "Cannot get post comemnt because the data is not an original post");
        $idx_root = $data->get('idx');

        return self::getCommentsInOrder($idx_root);
    }

    private static function getCommentsInOrder($idx_root)
    {
        $comments = post_data()->rows("idx_root=$idx_root AND idx_parent>0");


        //$comments = self::multiPreProcess($comments);
    }





    /**
     *
     *
     * @Attention It create a new post and sets to current data.
     *
     * @Attention - idx_config, idx_user, title, content MUST be set in options.
     *
     * @param array $options
     * @return $this|bool|PostData
     *
     * @code
        $data = post_data()->newPost([
            'idx_config' => $config->idx,
            'title'=>'hello',
            'content' => 'This is content',
        ]);
     * @endcode
     */
    public static function newPost(array $options) {
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


        // set idx_root
        if ( $options['idx_parent'] ) {
            post_data()->which($data->get('idx'))
                ->set('idx_root', post_data($options['idx_parent'])->get('idx_root'))
                ->save();
        }
        else {
            post_data()->which($data->get('idx'))->set('idx_root', $data->get('idx'))->save();
            $data->set('idx_root', $data->get('idx'));
        }

        self::setCurrent($data);
        return $data;
    }




}
