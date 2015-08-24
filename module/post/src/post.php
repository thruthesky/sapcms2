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
    public static function admin() {
        return Response::renderSystemLayout([
            'template'=>'post.layout',
            'page'=>'post.admin',
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
            return Response::redirect('/post/config/list');
        }
    }


    public static function listPostConfig() {
        return Response::render([
            'template'=>'post.layout',
            'page'=>'post.config.list',
        ]);
    }

    public static function listPostData() {
        $config = post_config()->getCurrent()->get();
        $posts = self::searchPostDataCondition();
        $total_record = self::countPostData();
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


    public static function editPostData() {
        return Response::render([
            'template'=>'post.layout',
            'page'=>'post.data.edit',
        ]);
    }

    public static function editSubmitPostData() {
        if ( self::validateEditSubmit() ) {
            return Response::render([
                'template'=>'post.layout',
                'page'=>'post.data.edit',
            ]);
        }

        $data = PostData::formSubmit();

        $post = PostData::preProcess(post_data($data->idx)->getFields());
        return Response::render([
            'template' => 'post.layout',
            'page'=>'post.data.view',
            'config' => post_config()->getCurrent()->getFields(),
            'post' => $post,
        ]);
    }



    public static function validateEditSubmit() {
        $id = request('id');
        $config = post_config($id);
        if ( empty($config) ) {
            return set_error(-50104, "No configuration record found by '$id'.");
        }

        $title = request('title');
        if ( empty($title) ) {
            return set_error(-50105, "Please input title");
        }
        $content = request('content');
        if ( empty($content) ) {
            return set_error(-50106, "Please input content");
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

        if ( isset($options['root']) ) $and[] = 'idx_root=0';
        if ( isset($options['comment']) ) $and[] = 'idx_root>0';

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
            'page'=>'post.view',
            'post'=>$post,
            'config' => $config->getFields(),
        ]);
    }

    public static function getViewUrl(array & $post)
    {
        $url = "/post/view?$post[title]&idx=$post[idx]";
        $url .= self::getUrlVariables();
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

}

