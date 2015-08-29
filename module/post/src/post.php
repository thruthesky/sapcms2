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
	
    public static function adminPostConfigEdit() {
        if ( ! $config = post_config()->getCurrent() ) error(-60400, "Could not find configuration");
        return Response::renderSystemLayout([
            'template' => 'post.layout',
            'page' => 'post.adminPostConfigEdit',
            'post_config' => $config->get(),
        ]);
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
        $config = post_config()->getCurrent()->get();
        return Response::render([
            'template'=>'post.layout',
            'page'=>'post.data.list',
            'config' => $config,
        ]);
    }
    public static function postListData() {
        return self::searchPostDataCondition(['comment'=>false]);
    }
    public static function postListDataCount() {
        return self::countPostData(['comment'=>false]);
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
            $url = self::urlViewComment($data->idx);
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

        return Response::redirect(self::urlPostView($data));
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
        $data = [
            'template'=>'post.layout',
            'page'=>'post.data.view',
        ];
        $post = PostData::preProcess(post_data(request('idx')));
        if ( empty($post) ) {
            error(-50119, "Post does not exist.");
            $data['page'] = 'post.error';
        }
        else {
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
    public static function urlPostView($post)
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
            $url = "/post/view?";
            $qs = ['idx'=>$post['idx']];
            if ( isset($post['title']) ) $qs['title'] = $post['title'];
            $url .= http_build_query($qs);
            $url .= self::getHttpVariablesAsRequest();
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
        return "/post/data/delete/" . $idx . "?" . self::getHttpVariablesAsRequest();
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
        // edit
        if ( $data ) {
            $url = "/post/edit?idx=" . $data->get('idx');
            $url .= self::getHttpVariablesAsRequest();
        }
        // new
        else {
            $config = post_config()->getCurrent();
            if ( $config ) {
                $url = "/post/edit?id=" . $config->get('id');
            }
            else {
                // error. There is no hint to get config. no 'idx', nor 'idx_config', nor 'id'.
            }
        }
        return $url;
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
        $url = "/admin/post/config/edit?idx=" . post_config()->getCurrent()->get('idx');
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
        /*
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
        */
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
     * @param $field
     * @return mixed
     *
     * @code
     * $no_item = post()->config(NO_ITEM);
    $no_page = post()->config(NO_PAGE);
     * @endcode
     */
    public function config($field) {
        return post_config()->getCurrent()->config($field);
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
            $data = post_data($idx)->set('content', request('content'))->save();
            return Response::redirect(post::urlPostView($data->get()));
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
        if ( empty($data) ) {
            error(-50581, "Post does not exists");
            return jsBack(getErrorString());
        }
        $id_config = $data->config('id');
        if ( $data->markAsDelete() ) {
            return Response::redirect(self::urlPostList($id_config, false));
        }
        else {
            return Response::redirect(self::urlPostView($data));
        }
    }

}

