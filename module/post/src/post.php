<?php
namespace sap\post;
use sap\src\Database;
use sap\src\Request;
use sap\src\Response;

class post {
    public static function index() {
        return Response::renderSystemLayout([
            'template'=>'post.layout',
            'page'=>'post.index',
        ]);
    }



    public static function configCreate() {
        return Response::renderSystemLayout([
            'template'=>'post.layout',
            'page'=>'post.config.create',
        ]);
    }


    public static function configCreateSubmit() {
        if ( post_config(request('id')) ) {
            error(-50100, "The post config ID is already exists.");
            return Response::renderSystemLayout([
                'template'=>'post.layout',
                'page'=>'post.config.create',
            ]);
        }
        else {
            post_config()
                ->set('id', request('id'))
                ->set('name', request('name'))
                ->save();
            return Response::redirect('/admin/post/config/list');
        }
    }


    public static function adminPostConfigList() {
        return Response::renderSystemLayout([
            'template'=>'post.layout',
            'page'=>'post.adminPostConfigList',
        ]);
    }

    /**
     * @return mixed|null
     */
    public static function listPostData() {
        $config = post_config()->getCurrent()->get();
        $options = ['comment'=>false];
        $posts = self::searchPostDataCondition($options);
        $total_record = self::countPostData($options);
        return Response::render([
            'template'=>'post.layout',
            'page'=>'post.data.list',
            'config' => $config,
            'posts' => $posts,
            'total_record' => $total_record,
        ]);
    }


    public static function searchPostData() {
        $posts = self::searchPostDataCondition();
        $total_record = self::countPostData();
        return Response::render([
            'template'=>'post.layout',
            'page'=>'post.data.search',
            'posts' => $posts,
            'total_record' => $total_record,
        ]);
    }



    public static function postEdit() {
        if ( submit() ) return self::formSubmitForPost();
        else return Response::render([
            'template'=>'post.layout',
            'page'=>'post.data.edit',
        ]);
    }


    /*
    public static function postEditSubmit()
    {
        if (self::isNewPostSubmit()) {
            return self::formSubmitForPost();
        }
        else if (self::isNewComment()) {

            return self::formSubmitForComment();
        }
        else if ( self::isPostUpdate() ) {
            return self::formSubmitForUpdate();
        }
        else {
            return setError(-50291, "Wrong form");
        }
    }
    */


    /**
     * https://docs.google.com/document/d/1624WxUtMw95UwCgj2YI25IWMbLkcNlbN_pHyugHRWyI/edit#heading=h.etolzwsd49az
     * @return int
     */
    public static function postCommentSubmit() {
        if ( self::validateContent() ) return jsBack(getErrorString());

        $config = post_config()->getCurrent();
        $options['idx_config'] = $config->get('idx');
        $options['idx_user'] = login('idx');
        $options['title'] = request('title');
        $options['content'] = request('content');

        $options['idx_root'] = post_data(request('idx_parent'))->get('idx_root');
        $options['idx_parent'] = request('idx_parent');
        $data = PostData::newPost($options);

        if ( empty($data) ) {
            setError(-50551, "Could not create a comment");
            return jsBack(getErrorString());
        }
        else {
            $url = self::getViewCommentUrl($data->idx);
            return Response::redirect($url);
        }
    }



    /*
    public static function formSubmitForUpdate() {
        $data = PostData::formSubmit();
        $url = self::getViewUrl($data->get());
        return Response::redirect($url);
    }
    */

    public static function formSubmitForPost() {

        if ( self::validateTitle() ) return Response::render([ 'template'=>'post.layout', 'page'=>'post.data.edit' ]);
        if ( self::validateConfig() ) return Response::render([ 'template'=>'post.layout', 'page'=>'post.data.edit' ]);
        if ( self::validateContent() ) return Response::render([ 'template'=>'post.layout', 'page'=>'post.data.edit' ]);

        if ( $idx = request('idx') ) {
            $options['idx'] = $idx;
            $options['title'] = request('title');
            $options['content'] = request('content');
            $data = PostData::updatePost($options);
        }
        else {
            $config = post_config()->getCurrent();
            $options['idx_config'] = $config->get('idx');
            $options['idx_user'] = login('idx');
            $options['title'] = request('title');
            $options['content'] = request('content');
            $data = PostData::newPost($options);
        }

        if ( empty($data) ) {
            setError(-50510, "Could not create a new post");
            return Response::render([ 'template'=>'post.layout', 'page'=>'post.data.edit' ]);
        }

        return Response::redirect("/post/view?idx=" . $data->get('idx'));
    }



    public static function validateTitle() {
        $title = request('title');
        if ( empty($title) ) return setError(-50105, "Please input title");
        else return OK;
    }
    public static function validateContent() {
        $title = request('content');
        if ( empty($title) ) return setError(-50105, "Please input content");
        else return OK;
    }
    public static function validateConfig() {
        $id = request('id');
        $config = post_config($id);
        if ( empty($config) ) return setError(-50105, "Wrong configuration");
        else return OK;
    }



    /**
     *
     *
     * @Attention It only checks INPUT from Web browser FORM Submit. You may not use this method on your own code.
     *
     * @return int|mixed
     */
    /*
    public static function validateEditSubmit() {
        if ( self::isNewPostSubmit() ) {
            return self::validateNewPost([
                'id' => request('id'),
                'title' => request('title'),
                'content' => request('content'),
            ]);
        }
        else if ( self::isNewComment() ) {
            return self::validateNewComment([
                'idx_parent' => request('idx_parent'),
                'content' => request('content'),
            ]);
        }
        else return setError(-50108, "Wrong form submit");
    }
    */

    /*
    public static function validateNewPost(array $options) {
        $id = $options['id'];
        $config = post_config($id);
        if ( empty($config) ) {
            return setError(-50104, "No configuration record found by '$id'.");
        }
        $title = $options['title'];
        if ( empty($title) ) {
            return setError(-50105, "Please input title");
        }
        $content = $options['content'];
        if ( empty($content) ) {
            return setError(-50106, "Please input content");
        }
        return OK;
    }
    */

    /**
     * @Attention USE this method to check if all the inputs are valid for creating new comment.
     * @param array $options
     * @return int|mixed
     */
    public static function validateNewComment(array $options) {
        if ( empty($options['idx_parent']) ) {
            return setError(-50201, "Wrong idx_parent");
        }
        $data = post_data($options['idx_parent']);
        if ( empty($data) ) return setError(-50202, "No parent data");
        if ( empty($options['content']) ) {
            return setError(-50106, "Please input content");
        }
        return OK;
    }


    /**
     * @param array $options
     * @return array
     */
    private static function searchPostDataCondition(array $options=[])
    {
        $fields = self::searchFields($options);
        $condition = self::searchCondition($options);
        $order = self::searchConditionOrder($options);
        $limit = self::searchLimit($options);
        $posts = post_data()->rows("$condition $order $limit", $fields);
        return PostData::multiPreProcess($posts);
    }

    private static function countPostData(array $options=[])
    {
        $condition = self::searchCondition($options);
        return post_data()->count("$condition");
    }

    private static function searchConditionOrder(array & $options)
    {
        if ( ! isset($options['order']) ) $order = "ORDER BY idx DESC";
        else $order = $options['order'];
        return $order;
    }

    private static function searchFields(array & $options)
    {
        if ( isset($options['fields']) ) return $options['fields'];
        else return '*';
    }
    private static function searchLimit(array & $options)
    {
        if ( isset($options['limit_from']) ) $limit_from = $options['limit_from'];
        else {
            $config = self::getOptionConfig($options);
            if ( $config ) {
                $no_item = $config->get('no_item_per_page');
            }
            if ( empty($no_item) ) $no_item = sysconfig(NO_ITEM);
            $limit_from = (page_no() - 1 ) * $no_item;
        }
        if ( isset($options['limit_to']) ) $limit_to = $options['limit_to'];
        else {
            $config = self::getOptionConfig($options);
            if ( $config ) $limit_to = $config->get('no_item_per_page');
            if ( empty($limit_to) ) $limit_to = sysconfig(NO_ITEM);
        }
        $re = "LIMIT $limit_from, $limit_to";

        system_log(__METHOD__);
        system_log($re);

        return $re;
    }


    /**
     *
     * Return Config Entity of the SEARCH condition.
     *
     * If $options['id'] is empty,
     * then, it looks for the HTTP INPUT as in request('id')
     *
     * @param array $options
     * @return bool|PostConfig
     */
    private static function getOptionConfig(array & $options) {
        if ( isset($options['id']) ) {
            return post_config($options['id']);
        }
        else if ( $id = request('id') ) {
            return post_config($id);
        }
        else return FALSE;
    }

    /**
     *
     *
     *
     * @param array $options
     *
     *  'id' - is the config id of the forum.
     *          if 'id' is not set, then it look for request(id)
     *
     * @return null|string
     *
     */
    private static function searchCondition(array & $options)
    {
        $config = null;
        $and = [];
        // post config
        $config = self::getOptionConfig($options);
        if ( $config )  {
            $and[] = "idx_config=".$config->get('idx');
        }

        if ( isset($options['comment']) ) {
            if ( $options['comment'] ){
                $and[] = 'idx_parent>0';
            }
            else {
                $and[] = 'idx_parent=0';
            }
        }

        if ( $q = request('q') ) {
            if ( $qn = request('qn') ) {
                if ( $user = user($q) ) {
                    $and[] = 'idx_user=' . $user->get('idx');
                }
                else {
                    $and[] = 'idx_user=-1'; // ERROR
                }
            }
            else if ( request('qt') || request('qc') ) {
                $qt = request('qt');
                $qc = request('qc');
                $words = explode(' ', $q, 2);
                foreach( $words as $word ) {
                    $or = [];
                    if ( $qt ) $or[] = "`title` LIKE '%$word%'";
                    if ( $qc ) $or[] = "content_stripped LIKE '%$word%'";
                    $and[] = '(' . implode(' OR ', $or) .')';
                }
            }
            else {
                // no filtering
                $words = explode(' ', $q, 2);
                foreach( $words as $word ) {
                    $or = [];
                    $or[] = "`title` LIKE '%$word%'";
                    $or[] = "content_stripped LIKE '%$word%'";
                    $and[] = '(' . implode(' OR ', $or) .')';
                }
            }
        }


        if ( $and ) {
            $re = implode(' AND ', $and);
            return $re;
        }
        else return null;
    }


    public static function viewPostData() {
        $config = null;
        $post = PostData::preProcess(post_data(request('idx')));
        if ( empty($post) ) error(-50119, "Post does not exist.");
        else {
            $config = post_config($post['idx_config']);
        }
        return Response::render([
            'template'=>'post.layout',
            'page'=>'post.data.view',
            'post'=>$post,
            'config' => $config->getFields(),
        ]);
    }

    /**
     * @Attention It will call 'getViewCommentUrl' if needed.
     *
     * @param array $post
     * @return string
     */
    public static function getViewUrl(array $post)
    {
        if ( $post['idx_parent'] ) {
            return self::getViewCommentUrl($post['idx']);
        }
        else {
            $url = "/post/view?$post[title]&idx=$post[idx]";
            $url .= self::getUrlVariables();
            return $url;
        }
    }

    /**
     *
     */
    public static function getViewCommentUrl($idx_comment)
    {
        $data = post_data($idx_comment);
        $title = $data->get('title');
        $idx_root = $data->get('idx_root');
        $url = "/post/view?$title&idx=$idx_root&idx_comment=$idx_comment";
        return $url;
    }



    public static function getListUrl() {
        $url = "/post/list?id=" . post_config()->getCurrent()->get('id');
        $url .= self::getUrlVariables();
        return $url;
    }

    public static function getEditUrl() {
        $url = "/post/edit?idx=" . post_data()->getCurrent()->get('idx');
        return $url;
    }

    public static function getUrlVariables() {
        $url = null;
        if ( $page_no = request('page_no') ) {
            $url .= "&page_no=$page_no";
        }
        if ( $q = request('q') ) {
            $url .= "&q=$q";
        }
        if ( $qn = request('qn') ) {
            $url .= "&qn=$qn";
        }
        if ( $qt = request('qt') ) {
            $url .= "&qt=$qt";
        }
        if ( $qc = request('qc') ) {
            $url .= "&qc=$qc";
        }
        return $url;
    }



    public static function adminPostConfigGlobal() {
        if ( submit() ) {
            config(NO_ITEM, request(NO_ITEM));
            config(NO_PAGE, request(NO_PAGE));
        }
        return Response::renderAdminPage([
            'template' => 'post.layout',
            'page' => 'post.adminPostConfigGlobal',
        ]);
    }


    /**
     * Return TRUE if the FORM submit is for creating a new post.
     * @return bool
     */
    /*
    public static function isNewPostSubmit()
    {
        if ( request('idx') ) return FALSE;
        if ( request('idx_parent') ) return FALSE;
        return FALSE;
    }
    */

    /**
     * Returns TRUE value if the FORM submit is for creating a new comment.
     *
     * @return Request
     */
    /*
    public static function isNewComment()
    {
        if ( request('idx') ) return FALSE;
        return request('idx_parent', FALSE);
    }

    public static function isPostUpdate()
    {
        return request('idx');
    }
    */

}

