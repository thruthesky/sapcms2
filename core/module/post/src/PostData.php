<?php
namespace sap\core\post;

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
        if ( empty($post) ) {
            return FALSE;
        }
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
     * Pre-process A post.
     * @Warning Do not use this method directly. Use preProcess or multiPreProcess
     * @param array $post
     * @return array
     */
    private static function pre(array & $post) {
        if ( !isset($post['idx_root']) || empty($post['idx_root']) ) {
            return error(-50571, "The post has a wrong data. This may be an error.");
        }
        $post['title'] = self::getTitleOrContent($post);
        if ( $post['idx_parent'] ) $post['url'] = post::urlViewComment($post['idx']);
        else $post['url'] = post::urlPostView($post);
        if ( $post['idx_user'] ) {
            $post['user'] = user($post['idx_user'])->getFields();
        }
        else $post['user'] = FALSE;

        if ( $post['content_type'] == 'H' ) {

        }
        else {
            $post['content'] = nl2br($post['content']);
        }
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
        else if ( ! empty($post['content_stripped']) ) return strcut($post['content_stripped'], 128);
        else return null;
    }

    /**
     * Returns title of the post.
     *  - if the title is empty, it returns part of content.
     * @param int $length
     * @return null|string
     */
    public function getTitle($length=256) {
        $post = $this->get();
        $title = self::getTitleOrContent($post);
        if ( $title ) return strcut($title, $length);
        else return null;
    }


    /**
     * Returns beginning part of content as in HTML Tag stripped.
     *
     * @param int $length
     * @return null|string
     */
    public function getDescription($length=256) {
        $content = $this->get('content_stripped');
        if ( ! empty($content) ) return strcut($content, $length);
        else return null;
    }

    public function url() {
        return url_post_view($this);
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
        else if ( segment(1) == 'edit' ) {
            return $this->load(segment(2));
        }
        else if ( self::$current ) {
            return self::$current;
        }
        else return FALSE;
    }

    public static function setCurrent(PostData & $data) {
        self::$current = $data;
    }

    public function getConfig() {
        $config = post_config($this->get('idx_config'));
        return $config;
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
     *
     * @code To get current post's comment
     *      $comments = post_data()->getComments();
     * @endcode
     *
     */
    public function getComments($idx=0, $field='*') {
        if ( empty($idx) ) {
            $data = post_data()->getCurrent();
        }
        else {
            $data = post_data($idx);
        }
        if ( empty($data) ) return setError(-50340, "Cannot find original post");
        if ( $data->get('idx_parent') ) return setError(-50341, "Cannot get post comemnt because the data is not an original post");
        $idx_root = $data->get('idx');

        return self::getCommentsInOrder($idx_root, $field);
    }

    /**
     * @param $idx_root
     * @param string $field
     * @return array
     *
     * @Attention Only this method returns in order of comment.
     * - Do not use other method to get comment in ordered.
     */
    private static function getCommentsInOrder($idx_root, $field='*')
    {
        return post_data()->rows("idx_root=$idx_root AND idx_parent>0 ORDER BY order_list ASC", $field);
    }


    /**
     *
     * @Attention You must use this method to create a new post because it set 'idx_root' and others.
     *
     * @Attention It create a new post and sets to current data.
     * @Attention It does not check if the post_config exists or not. It must be checked earlier before this method call
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
     *
     * @example For order list example see - post/script/order-list.php
     *
     *
     * @Attention it sets setCurrent() with newly created post.
     *      This leads post_config()->getCurrent() work.
     *
     * @code
     *
    $data = post_data()->newPost([
    'idx_config' => $config->idx,
    'title'=>'hello',
    'content' => 'This is content',
    ]);
    $this->assertTrue( post_config()->getCurrent() instanceof PostConfig);
    $this->assertTrue( post_config()->getCurrent()->id == $id );
     * @endcode
     *
     *
     */
    public static function newPost(array $options) {
        $data = post_data();

        $data->set($options);
        $data->set('delete', 0);
        $data->set('block', 0);
        $data->set('blind', 0);
        $data->set('report', 0);
        $data->set('order_list', 0);
        $data->set('content_stripped', strip_tags($options['content']));
        $data->set('ip', ip());				
        if ( ! isset($options['domain']) ) $data->set('domain', domain());		
        if ( ! isset($options['user_agent']) ) $data->set('user_agent', user_agent());//edited by benjamin previously if ( ! isset($options['user_agent']) ) $data->set('domain', user_agent())
        $data->save();
        $idx = $data->get('idx');


        // set idx_root into table record
        $parent = null;
        if ( isset($options['idx_parent']) && $options['idx_parent'] ) {
            $parent = post_data($options['idx_parent']);
            $idx_root = $parent->get('idx_root');
            $depth = $parent->get('depth') + 1;
        }
        else {
            $idx_root = $data->get('idx');
            $depth = 0;
        }




        $up = ['idx_root'=>$idx_root, 'depth'=>$depth];

        // To only set a few fields. Not whole fields.
        post_data()->which($data->get('idx'))->set($up)->save();

        // set idx_root into the object(memory)
        $data->set('idx_root', $idx_root);


        // set order_list Only On comment.
        if ( $parent ) {
            $new_order_list = 0;
            if ( $count = self::countComment($idx_root) ) {

                if ( $parent->get('idx') == $idx_root ) {
                    $max = self::maxOrderListOfRoot($idx_root);
                    $new_order_list = round($max + 2);
                }
                else if ( $max = self::maxOrderListOfParent($parent->get('idx')) ) {
                    if ( $next = self::nextOrderListOfRoot($idx_root, $max) ) {
                        if ( $max == $next ) {
                            $next = self::nextOrderListOfRoot($idx_root, $max);
                            echo "\nERROR max and next are the same\n";
                            exit;
                        }
                        $new_order_list = ( $max + $next ) / 2;
                        //echo "$idx=$idx,idx_parent=$options[idx_parent] , max:$max / next:$next = new_order_list=$new_order_list\n";
                    }
                    else {
                        $new_order_list = round($max + 2);
                        //echo "$idx=$idx,max:round($max +2) = new_order_list=$new_order_list\n";
                    }
                }
                else {
                    $new_order_list = 1;
                }
                $up['order_list'] = $new_order_list;
            }
            else {
                // echo "No comment\n";
            }
            //system_log($up);
            post_data()->which($data->get('idx'))->set('order_list', $new_order_list)->save();
        }


        /**
         * Sets no_comment on $idx_root
         */
        if ( $parent ) {
            $no_comment = post_data()->countComment($idx_root);
            post_data()->which($idx_root)->set('no_comment', $no_comment)->save();
            //post_data($idx_root)->set('no_comment', $no_comment)->save();
        }

        self::setCurrent($data);
        return $data;
    }

    /**
     *
     * Updates post data.
     *
     *
     *
     * @param $options
     *      - $options['idx'] is the mandatory field.
     * @return $this|bool|PostData
     */
    public static function updatePost($options) {
        $idx = $options['idx'];
        $data = post_data($idx);
        if ( empty($data) ) return error(-50508, "No post by that idx");
        unset($options['idx']);
        foreach( $options as $field => $value ) {
            $data->set($field, $value);
        }
        $data->save();
        return $data;
    }

    /**
     *
     * Creates a post with random title and content.
     *
     *
     * @param $options
     *      - 'idx_config' is the title
     *      - 'idx_parent' is the parent
     * @return $this|bool|PostData - PostData Entity
     *
     *
     * @Attention It does not check if the post_config exists or not.
     *
     * @NOTE If you do not need a post_config, you can just omit it.
     */
    public static function createRandomPost($options=[]) {
        if ( ! isset($options['title']) ) $options['title'] ="TITLE " . date("M-d H:i:s");
        if ( ! isset($options['content']) ) $options['content'] = "Content" . date("r");
        return post_data()->newPost($options);
    }

    /**
     * @param $idx_root
     * @return mixed
     *
     * @code
     *  $max = post_data()->countComment($idx_root);
     * @endcode
     */
    public static function countComment($idx_root) {
        return post_data()->count("idx_root=$idx_root AND idx_parent>0");
    }

    /**
     * Returns the MAX order_list among the children of parents.
     *
     * @param $idx_parent
     * @return mixed
     */
    private static function maxOrderListOfParent($idx_parent)
    {
        $max = 0;
        $tree = self::getRecursiveTreeWithSelf($idx_parent);
        if ( $tree ) {
            foreach ( $tree as $comment ) {
                if ( $comment['order_list'] > $max ) {
                    $max = $comment['order_list'];
                }
            }
        }
        return $max;
    }

    /**
     *
     * Returns the list of a tree based on $idx_parent by Recursive call
     *
     * @param $idx_parent
     * @param string $fields
     * @return array
     *
     * @code
     * print_r( post_data()->getRecursiveTree($post->get('idx'), "idx, idx_root, idx_parent, title, order_list"));
     * print_r( post_data()->getRecursiveTree($child1->get('idx'), "idx, idx_root, idx_parent, title, order_list"));
     * print_r( post_data()->getRecursiveTree($child2_1->get('idx'), "idx, idx_root, idx_parent, title, order_list"));
     * @endcode
     *
     */
    public static function getRecursiveTree($idx_parent, $fields='idx, idx_root, idx_parent, depth, order_list') {
        $rows = post_data()->rows("idx_parent=$idx_parent", $fields);
        if ( $rows ) {
            foreach( $rows as $row ) {
                $ret = self::getRecursiveTree($row['idx'], $fields);
                $rows = array_merge($rows, $ret);
            }
        }
        return $rows;
    }


    /**
     *
     * Returns an Array of all post data record of $idx_root
     *
     *  - It even includes the root post.
     *
     * @param $idx_root
     * @param string $field
     * @return array
     */
    private static function getThread($idx_root, $field='*')
    {
        return post_data()->rows("idx_root=$idx_root", $field);
    }



    /**
     * Returns the list of a tree including the post data of input parameter idx.
     * @param $idx
     * @param string $fields
     * @return array
     */
    public static function getRecursiveTreeWithSelf($idx, $fields='idx, idx_root, idx_parent, depth, order_list') {
        $post = post_data()->row("idx=$idx", $fields);
        $rows = self::getRecursiveTree($idx, $fields);
        array_unshift($rows, $post);
        return $rows;
    }


    /**
     * @param $idx_root
     * @param $order_list
     * @return mixed
     */
    private static function nextOrderListOfRoot($idx_root, $order_list)
    {
        return post_data()->result("order_list", "idx_root=$idx_root AND order_list>$order_list ORDER BY order_list ASC");
    }


    /**
     * Returns max order list value of the root and comments.
     * @param $idx_root
     * @return mixed
     */
    private static function maxOrderListOfRoot($idx_root)
    {
        return post_data()->result("MAX(order_list)", "idx_root=$idx_root");
    }


    /**
     *
     * @return bool - same as deleteThreadIfAllDeleted()
     *
     * @see test_post_data_comment_delete()
     */
    public function markAsDelete() {
        $this->set('title','');
        $this->set('content','');
        $this->set('content_stripped','');
        $this->set('delete', true)
		->set( 'int_1', 0 )
		->set( 'int_2', 0 )
		->set( 'int_3', 0 )
		->set( 'int_4', 0 )
		->set( 'int_5', 0 )
		->set( 'int_6', 0 )
		->set( 'int_7', 0 )
		->set( 'int_8', 0 )
		->set( 'int_9', 0 )
		->set( 'int_10', 0 );
        $this->save();
        self::deleteFiles($this->get('idx'));


        return self::deleteThreadIfAllDeleted($this->get('idx_root'));
    }


    /**
     *
     * Delete a post and its all comments ONLY IF all are marked as deleted.
     *
     * @param $idx_root
     * @return bool
     *      - TRUE if the post and its all comments are delete.
     *      - FALSE otherwise.
     *
     */
    private static function deleteThreadIfAllDeleted($idx_root)
    {

        $root = post_data($idx_root);

        if ( empty($root) ) return FALSE;
        if ( ! $root->get('delete') ) return FALSE;

        $children = self::getThread($idx_root, 'delete');
        if ( $children ) {
            foreach( $children as $comment ) {
                if ( ! $comment['delete'] ) return FALSE;
            }
        }

        self::forceDeleteThread($idx_root);
        return TRUE;
    }


    /**
     * Delete a post and its all comments Forcefully even if the post or its comments are not marked as deleted.
     *
     * @param $idx_root
     */
    private static function forceDeleteThread($idx_root)
    {
        $children = self::getThread($idx_root, 'idx');
        foreach( $children as $child ) {
            self::deletePostComplete($child['idx']);
        }
    }

    /**
     * Deletes a post or a comment completely.
     *
     * @param $idx
     *
     */
    private static function deletePostComplete($idx)
    {
        $data = post_data($idx);
        if ( $data ) $data->delete();
        self::deleteFiles($idx);
    }


    /**
     *
     * @param $idx
     *
     */
    private static function deleteFiles($idx)
    {
        $files = data()->loadBy('post', 'file', $idx);
        if ( $files ) {
            foreach( $files as $file ) {
                $file->deleteFile();
            }
        }
    }


    /**
     *
     * Returns the value of PostConfig entity.
     *
     *
     * @param $field
     * @return array|null
     *
     * @code
     * $this->assertTrue($data->config('id') == self::$id);
     * @endcode
     */
    public function config($field) {
        return post_config($this->get('idx_config'))->get($field);
    }


    /**
     *
     */
    public function updateFormSubmitFiles() {
        $fid = request('fid');
        if ( empty($fid) ) return;

        sys()->log(__METHOD__);
        sys()->log("fid: $fid");

        $idxes = explode(',', $fid);
        if ( empty($idxes) ) return;

        foreach( $idxes as $idx ) {
            if ( is_numeric($idx) ) {
                $file = data($idx);
                if ( $file ) {
                    $file
                        ->set('module', 'post')
                        ->set('type', $this->get('idx_config'))
                        ->set('idx_target', $this->get('idx'))
                        ->set('finish', 1)
                        ->save();
                }
            }
        }
    }


    /**
     *
     * Attaches a file to a post.
     *
     * @param $path
     * @param string $form_name
     * @return $this|bool
     * @code
     *    $post = post_data()->newPost($option);
     *    $data = $post->attachFile("tmp/wedding.png");
     * @endcode
     */
    public function attachFile($path, $form_name='files') {
        return data()->saveFile([
            'path'          => $path,
            'module'        => 'post',
            'type'          =>  $this->get('idx_config'),
            'idx_target'    => $this->get('idx'),
            'idx_user'      => $this->get('idx_user'),
            'form_name'     => $form_name,
            'finish'        => 1,
        ]);
    }


    /**
     *
     * Returns Data Entity object of the first uploaded image of the  post.
     *
     *
     *
     * @param null $form_name
     * @return bool|Entity
     *
     *      - FALSE if there is no image.
     *
     * @code
     * di(post_data(1208)->getImage());
     * @endcode
     */
    public function getImage($form_name=null) {
        $conds = ["module='post'","idx_target=".$this->get('idx')];
        if ($form_name) $conds[] = "form_name='$form_name'";
        $conds[] = "mime LIKE 'image%'";
        $cond = implode(" AND ", $conds);
        return data()->query("$cond ORDER BY idx ASC");
    }

    /**
     * Returns uploaded images of the post.
     * @param null $form_name
     * @return array
     * @code
     * di(post_data(1208)->getImages());
     * @endcode
     */
    public function getImages($form_name=null) {
        $conds = ["module='post'","idx_target=".$this->get('idx')];
        if ($form_name) $conds[] = "form_name='$form_name'";
        $conds[] = "mime LIKE 'image%'";
        $cond = implode(" AND ", $conds);
        return data()->files("$cond ORDER BY idx ASC");
    }

    /**
     * Returns all files of the post.
     * @param $form_name
     * @return array
     * @code
     * di(post_data(1208)->getFiles());
     * @endcode
     */
    public function getFiles($form_name=null) {
        $conds = ["module='post'","idx_target=".$this->get('idx')];
        if ($form_name) $conds[] = "form_name='$form_name'";
        $cond = implode(" AND ", $conds);
        return data()->files("$cond ORDER BY idx ASC");
    }


    /**
     *
     * Returns value of a post or comment.
     *
     * @note Use this methods if you do not want to load the whole record from database.
     *
     *      - It will only read a field.
     *
     * @param $idx
     * @param $field
     * @return mixed
     */
    public function field($idx, $field) {
        return $this->result($field, "idx=$idx");
    }

}
