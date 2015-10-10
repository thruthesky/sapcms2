<?php
namespace sap\core\post;
use sap\core\data\Data;
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
	
    public static function adminPostConfigEdit() {
        $data = [
            'template' => 'post.layout',
            'page' => 'post.adminPostConfigEdit'
        ];

        $config = post_config()->getCurrent();

        if ( empty($config) ) {
            error(-60400, "Could not find configuration");
        }
        else {
            $data['post_config'] = $config->get();
            $data['widget_list'] = self::loadWidget('post_list');
            $data['widget_view'] = self::loadWidget('post_view');
            $data['widget_edit'] = self::loadWidget('post_edit');
            $data['widget_comment_edit'] = self::loadWidget('post_comment_edit');
        }

        return Response::renderSystemLayout($data);
    }

    /**
     * @return int|mixed|null
     *
     * @TODO If there error, you need to auto-fill the input on the form.
     * @TODO Wrong error handling
     *
     */
    public static function adminPostConfigEditSubmit() {
        $id = request( 'id' );
        if( empty( $id ) ) {
            return self::postConfigSubmitError(-60415,'Missing ID','post.adminPostConfigEdit');
        }
        else {
            $input = request();
            unset( $input['id'] );
            $post_config = post_config($id);
            if( $post_config ){
                foreach( $input as $k => $v ) {
                    $post_config->set( $k, $v );
                }
                $post_config->save();
                $data['post_config'] = $post_config->fields;
            }
            else{
                return self::postConfigSubmitError(-60401,"Invalid ID [ $id ]",'post.config.edit');
            }
        }
        return Response::redirect('/admin/post/config/edit?id='.$id);
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
                ->set('description', request('description'))
                ->save();
            return Response::redirect('/admin/post/config/list');
        }
    }


	public static function configDeleteSubmit() {
		$id = request( 'id' );
		if( empty( $id ) ) {
			//redundant code with configEditSubmit() for if missing ID			
			return self::postConfigSubmitError(-60400,'Missing ID','post.adminPostConfigList');
		}
		else{			
			$post_config = post_config($id);	
			if( !empty( $post_config ) ) $post_config->delete();
			else {						
				return self::postConfigSubmitError(-60401,"Invalid ID [ $id ]",'post.adminPostConfigList');
			}
		}				
		return Response::redirect('/admin/post/config/list');
	}
	
	public static function postConfigSubmitError( $code, $message, $page ){
		error($code, $message);		
		$data = [];
		$data['template'] = 'post.layout';
		$data['page'] = $page;
		return Response::renderSystemLayout($data);
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
    public static function postList() {
        $config = post()->getCurrentConfig();
        return Response::render([
            'template'=>'post.layout',
            'page'=>'post.list',
            'config' => $config,
        ]);
    }

    public static function postListData(array $options=[]) {
        $options['comment'] = false;
        return self::searchPostDataCondition($options);
    }

    public static function postListDataCount(array $options=[]) {
        $options['comment'] = false;
        return self::countPostData($options);
    }

    public static function searchPostData() {
        $posts = self::searchPostDataCondition();
        $total_record = self::countPostData();
        return Response::render([
            'template'=>'post.layout',
            'page'=>'post.search',
            'posts' => $posts,
            'total_record' => $total_record,
        ]);
    }

    /**
     * Returns with full comment.
     * @param array $options
     * @return array
     */
    public static function postListWithComment(array $options=[]) {
        $options['comment'] = false;
        $posts = self::searchPostDataCondition($options);
        if ( $posts ) {
            foreach( $posts as &$post ) {
                $post['comments'] = post_data()->getComments($post['idx']);
            }
        }
        return $posts;
    }



    public static function postCreate($id) {
        return Response::render([
            'template'=>'post.layout',
            'page'=>'post.edit',
        ]);
    }

    public static function postCreateSubmit() {

        if ( self::validateTitle() ) return self::templateEdit();
        if ( self::validateConfig() ) return self::templateEdit();
        if ( self::validateContent() ) return self::templateEdit();


        $config = post_config()->getCurrent();
        $options['idx_config'] = $config->get('idx');
        $options['idx_user'] = login('idx');
        $options['title'] = request('title');
        $options['content'] = request('content');
        $options['content_type'] = request('content_type');
        $data = PostData::newPost($options);

        if ( empty($data) ) return self::templateError(-50510, "Could not create a new post");

        $data->updateFormSubmitFiles();
        return Response::redirect(self::urlPostView($data));
    }


    /**
     *
     * @return mixed|null
     *
     */
    public static function postEdit($idx) {
        $post = post_data()->getCurrent();
        if ( empty($post) ) return self::errorNoPostToEdit();
        if ( ! is_post_admin() && ! is_my_post($post->get('idx')) ) return self::templateErrorNotYourPost();
        return Response::render([
            'template'=>'post.layout',
            'page'=>'post.edit',
        ]);
    }

    public static function postEditSubmit() {
        $idx = request('idx');
        if ( empty($idx) ) return self::templateError(-50510, "Could not create a new post");
        if ( ! is_post_admin() && ! is_my_post($idx) ) return self::templateErrorNotYourPost();
        if ( self::validateConfig() ) return self::templateEdit();
        if ( self::validateContent() ) return self::templateEdit();



        $options['idx'] = $idx;
        $options['title'] = request('title');
        $options['content'] = request('content');
        $data = PostData::updatePost($options);
        if ( empty($data) ) return self::templateError(-50510, "Could not create a new post");
        $data->updateFormSubmitFiles();
        return Response::redirect(self::urlPostView($data));


    }






    /**
     * https://docs.google.com/document/d/1624WxUtMw95UwCgj2YI25IWMbLkcNlbN_pHyugHRWyI/edit#heading=h.etolzwsd49az
     * @return int
     */
    public static function postCommentSubmit() {


        if ( self::validateContent() ) {
            return jsBack(getErrorString());
        }
        $config = post_config()->getCurrent();
        if ( empty($config) ) {
            return self::templateError(-50505, "Wrong post configuration");
        }
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
            $data->updateFormSubmitFiles();
            $url = self::urlViewComment($data->idx);
            return Response::redirect($url);
        }
    }


    public static function validateTitle() {
        $title = request('title');
        if ( empty($title) ) return setError(-50105, "Please input title");
        else return OK;
    }
    public static function validateContent() {
        $title = request('content');
		$fid = request('fid');
		//added by benjamin
		if( !empty( $fid ) ) return OK;
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
            if ( empty($no_item) ) $no_item = self::globalConfig(NO_ITEM);
            $limit_from = (page_no() - 1 ) * $no_item;
        }
        if ( isset($options['limit_to']) ) $limit_to = $options['limit_to'];
        else {
            $config = self::getOptionConfig($options);
            if ( $config ) $limit_to = $config->get('no_item_per_page');
            if ( empty($limit_to) ) $limit_to = self::globalConfig(NO_ITEM);
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
     *      - Firstly, look for $options['id']
     *      - Lastly, look for post_config()->getCurrent();
     *
     * @param array $options
     * @return bool|PostConfig
     */
    private static function getOptionConfig(array & $options) {
        if ( isset($options['id']) ) {
            return post_config($options['id']);
        }
        else if ( $config = post_config()->getCurrent() ) {
            return $config;
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
            $idx = $config->get('idx');
            if ( $idx ) {
                $and[] = "idx_config=$idx";
            }
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


    public static function postView() {
        $data = [
            'template'=>'post.layout',
            'page'=>'post.view',
        ];
        $post_data = post_data(request('idx'));
        if ( empty($post_data) ) {
            error(-50119, "Post does not exist.");
            $data['page'] = 'post.error';
        }
        else {
            //$post_data->set('no_view', $post_data->get('no_view') + 1)->save();
            post_data()->which($post_data->get('idx'))->set('no_view', $post_data->get('no_view') + 1)->save();
            $post = PostData::preProcess($post_data);
            $config = post_config($post['idx_config']);
            $data['config'] = $config->getFields();



            $data['post'] = $post;
        }
        return Response::render($data);
    }

    /**
     * @Attention It will call 'urlViewComment' if needed.
     *
     * @param $post - is the array of post data entity record OR it can be Post data entity.
     * @return string
     *
     * @code
    $data = post_data($idx)->set('content', request('content'))->save();
    return Response::redirect(post::getViewUrl($data));
     * @endcode
     * @code
    $data = post_data($idx)->set('content', request('content'))->save();
    return Response::redirect(post::getViewUrl($data->get()));
     * @endcode
     */
    public static function urlPostView($post, $length_title=64)
    {
        if ( empty($post) ) {
            return error(-50591, "post is empty");
        }
        if ( $post instanceof PostData ) {
            $post = $post->get();
        }
        if ( isset($post['idx_parent']) && $post['idx_parent'] ) {
            return self::urlViewComment($post['idx']);
        }
        else {
            $url = "/post/view";
            $ex = null;

            $qs = ['idx'=>$post['idx']];
            if ( $length_title ) {
                if ( $post['title'] ) $qs['title'] = strcut($post['title'], $length_title);
            }


            $ex .= http_build_query($qs);
            $ex .= self::getHttpVariablesAsRequest();
            if ( $ex ) $url .= "?$ex";

            return $url;
        }
    }

    /**
     * @param int $idx
     * @return string
     */
    public static function urlPostDelete($idx=0)
    {
        if ( empty($idx) ) $idx = post_data()->getCurrent()->get('idx');
        $url = "/post/data/delete/" . $idx;
        $q = self::getHttpVariablesAsRequest();
        if ( $q ) {
            $url = $url . "?" . self::getHttpVariablesAsRequest();
        }
        return $url;
    }


    /**
     *
     */
    public static function urlViewComment($idx_comment)
    {
        $data = post_data($idx_comment);
        $title = $data->get('title');
        $idx_root = $data->get('idx_root');
        $url = "/post/view?$title&idx=$idx_root&idx_comment=$idx_comment";
        $url .= self::getHttpVariablesAsRequest();
        return $url;
    }

    public static function urlPostEdit() {
        $data = post_data()->getCurrent();
        if ( $data ) {
            $url = "/post/edit/" . $data->get('idx');
            $url .= self::getHttpVariablesAsRequest();
            return $url;
        }
        return null;
    }


    public static function urlPostCreate() {
        $config = post_config()->getCurrent();
        if ( $config ) {
            return "/post/create/" . $config->get('id');
        }
        return null;
    }


    public static function urlPostCommentEdit($idx)
    {
        $url = "/post/comment/edit?idx=$idx";
        $url .= self::getHttpVariablesAsRequest();
        return $url;
    }

    /**
     * @return string
     */
    public static function urlEditPostConfig() {
        $url = "/admin/post/config/edit?idx=" . post()->getCurrentConfig('idx');
        return $url;
    }

    /**
     * @param bool $add_vars - if it's TRUE, then it just list 1st page without options.
     *
     * @return string
     */
    public static function urlPostList($id=null, $add_vars=true) {
        if ( empty($id) ) {
            $data = post_config()->getCurrent();
            if ( $data ) {
                $id = $data->get('id');
            }
            else {
                $id = null; // error ...
            }
        }
        $url = "/post/list?id=$id";
        if ( $add_vars ) $url .= self::getHttpVariablesAsRequest();
        return $url;
    }

    public static function getHttpVariables() {
        return [
            'page_no',
            'q',
            'qn',
            'qt',
            'qc',
        ];
    }

    public static function getHttpVariablesAsHidden() {
        $markup = null;
        foreach( self::getHttpVariables() as $k ) {
            if ( $v = request($k) ) {
                $markup .= "<input type='hidden' name='$k' value='$v'>". PHP_EOL;
            }
        }
        return $markup;
    }

    public static function getHttpVariablesAsRequest() {
        $url = null;
        foreach( self::getHttpVariables() as $k ) {
            if ( $v = request($k) ) $url .= "&$k=$v";
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
     * @return mixed|null
     */
    private static function templateErrorNotYourPost()
    {
        return self::templateError(-50554, "This is not your post. You cannot edit or delete this post.");
    }

    private static function errorNoPostToEdit()
    {
        error(-50555, "No post to edit. You have access post edit page but there is not post to edit.");
        return self::templateEdit();
    }

    private static function templateEdit()
    {
        return Response::render([ 'template'=>'post.layout', 'page'=>'post.edit' ]);
    }

    private static function templateError($code, $message)
    {
        setError($code, $message);
        return Response::render([ 'template'=>'post.layout', 'page'=>'post.error' ]);
    }

    private static function errorPostNotExists()
    {
        return self::templateError(-50564, "Post does not exists.");
    }

    /**
     *
     * Returns global configuration data.
     *
     * @note Use this method if there is no default value on the forum configuration
     *
     * @param $field
     * @return bool|mixed|null
     */
    public static function globalConfig($field)
    {
        return sysconfig($field);
    }

    /**
     *
     * Returns the value of input configuration field of the Current forum.
     * @param $field
     * @return mixed
     *
     * @Attention if the value of the configuration is equal to '===' FALSE, then it looks up for the system ( or global ) configuration value.
     *
     * @code
     *    $no_item = post()->config(NO_ITEM);
     *    $no_page = post()->config(NO_PAGE);
     * @endcode
     */
    public function config($field) {
        $data = post_data()->getCurrent();
        if ( empty($data) ) {
            $re = FALSE;
        }
        else $re = $data->config($field);

        if ( empty($re) ) {
            switch( $field ) {
                case NO_ITEM : return self::globalConfig(NO_ITEM);
                case NO_PAGE : return self::globalConfig(NO_PAGE);
                default: return FALSE;
            }
        }
        else return $re;

    }




    public static function postCommentEdit() {
        return Response::render([
            'template' => 'post.layout',
            'page' => 'post.comment.edit',
        ]);
    }

    public static function postCommentEditSubmit() {
        $idx = request('idx');
        if ( $idx ) {
            if ( is_my_post($idx) ) {
                $data = post_data($idx)->set('content', request('content'))->save();
                $data->updateFormSubmitFiles();
                return Response::redirect(post::urlPostView($data->get()));
            }
            else return self::templateErrorNotYourPost();
        }
        else {
            error(-50559, "Wrong idx");
            return Response::render([
                'template' => 'post.layout',
                'page' => 'post.comment.edit',
            ]);
        }
    }




    /**
     * @param $idx
     * @return int
     */
    public static function postDataDelete($idx) {
        $data = post_data($idx);
        if ( empty($data) ) return self::errorPostNotExists();
        if ( ! is_my_post($data) ) return self::templateErrorNotYourPost();
        $id_config = $data->config('id');
        if ( $data->markAsDelete() ) {
            return Response::redirect(self::urlPostList($id_config, false));
        }
        else {
            return Response::redirect(self::urlPostView($data));
        }
    }



    public function data() {
        return data();
    }


    /**
     *
     * @param null $config_name
     * @param int $from
     * @param int $number
     * @return array
     *
     * @code
     *      $posts = post()->getLatestPost('test', 2, 4);
     * @endcode
     *
     */
    public function getLatestPost($config_name=null,$from=0, $number=1) {
        $cond = null;
        if ( $config_name ) {
            $config = post_config($config_name);
            if ( empty($config) ) {
                // error
            }
            else {
                $cond = "idx_config=" . $config->get('idx') . ' AND ';
            }
        }
        $cond .= " idx_parent=0 ORDER BY idx DESC LIMIT $from, $number";
        return post_data()->queries($cond);
    }

    /**
     *
     * Returns a File Entity Object of a Forum of $config_name which is on a post that is newly posted with image.
     *
     *
     * @param int $from - From what number of post in DESC order.
     * @param $config_name - is the forum. it's options. if it's empty, it searches for whole forum.
     * @return bool|Data
     * @code
     *  $src = post()->getLatestPostImage('qna')->url();
     *  $src = post()->getLatestPostImage()->url();
     *  $src_top_banner = post()->getLatestPostImage(2)->urlThumbnail(400, 200);
     * @endcode
     */
    public function getLatestPostImage($from=0, $config_name=null)
    {
        $conds = ["module='post'"];
        if ( $config_name ) {
            $config = post_config($config_name);
            if ( empty($config) ) return FALSE;
            $idx_config = $config->get('idx');
            $conds[] = "type=$idx_config";
        }
        $conds[] = "mime LIKE 'image%'";
        $cond = implode(" AND ", $conds);
        return data()->query("$cond GROUP BY idx_target ORDER BY created DESC, idx_target DESC, idx ASC LIMIT $from, 1");
    }

    /**
     *
     * Returns Data Entity objects of the first uploaded image on each post.
     *
     * @param int $from - From where you want to get.
     * @param int $to - How many post you want to look for.
     * @param null $config_name - Forum configuration idx
     * @return array|bool
     */
    public function getLatestPostImages($from=0, $to=5, $config_name=null) {
        $conds = ["module='post'"];
        if ( $config_name ) {
            $config = post_config($config_name);
            if ( empty($config) ) return FALSE;
            $idx_config = $config->get('idx');
            $conds[] = "type=$idx_config";
        }
        $conds[] = "mime LIKE 'image%'";
        $cond = implode(" AND ", $conds);
        return data()->files("$cond GROUP BY idx_target ORDER BY created DESC, idx_target DESC, idx ASC LIMIT $from, $to");
    }





    /**
     *
     * Returns the value of current forum's configuration.
     *
     * @note it is a safe and short way of using "post_config()->getCurrent()->get('id');"
     *
     * @param $field
     *
     * @return bool
     */
    public function getCurrentConfig($field=null)
    {
        $config = post_config()->getCurrent();
        if ( empty($config) ) return null;
        else return $config->get($field);
    }


    public static function voteGood($idx) {
        $re = post_vote_history()->voteGood($idx);
        if ( isError($re) ) $re = getLastError();
        return Response::json($re);
    }

    public static function voteBad($idx) {
        $re = post_vote_history()->voteBad($idx);
        if ( isError($re) ) $re = getLastError();
        return Response::json($re);
    }

    /**
     *
     *
     * @param $type
     * @return array
     * Array
     *    (
     *    [widget/post_list_simple/post_list_simple.php] => Simple Post List
     *    [core/module/post/widget/post_list/post_list.php] => Basic Post List
     *    )
     *
     *
     * @code
     *      $data['widget_list'] = self::loadWidget('post_list');
     * @endcode
     *
     *
     *
     */
    public static function loadWidget($type) {
        $ret = [];
        widget()->loadParseIni();
        $ini = widget()->loadParseIni("core/module/post/widget/*");
        if ( isset($ini[$type]) ) {
            foreach( $ini[$type] as $data ) {
                $name = $data['info']['name'];
                $pi = pathinfo($data['path']);
                $folder = str_replace(".ini", "", $pi['filename']);
                $ret[$folder] = $name;
            }
            return $ret;
        }
        else return [];
    }
}

