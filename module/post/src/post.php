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
        $posts = self::searchPostData();
        return Response::render([
            'template'=>'post.layout',
            'page'=>'post.data.list',
            'config' => $config,
            'posts' => $posts,
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
        $config = post_config( request('id') );
        $data = post_data();
        $data->set('idx_config', $config->get('idx'));
        $data->set('title', request('title'));
        $data->set('content', request('content'));
        $data->save();
        $post = post_data($data->idx)->getFields();
        return Response::render([
            'template' => 'post.layout',
            'page'=>'post.data.view',
            'config' => $config->getFields(),
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

    private static function searchPostData(array $options=[])
    {
        $fields = self::searchFields($options);
        $condition = self::searchCondition($options);
        $order = self::searchConditionOrder($options);
        $limit = self::searchLimit($options);


        $posts = post_data()->rows("$condition $order $limit", $fields);
        return PostData::preProcess($posts);
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
        else $limit_from = 0;
        if ( isset($options['limit_to']) ) $limit_to = $options['limit_to'];
        else $limit_to = 10;
        return "LIMIT $limit_from, $limit_to";
    }

    private static function searchCondition(array & $options)
    {
        $config = null;
        $and = [];
        if ( isset($options['id']) ) {
            if ( $config = post_config($options['id']) ) {
                $and[] = "idx_config=$config[idx]";
            }
        }
        if ( isset($options['root']) ) $and[] = 'idx_root=0';
        if ( isset($options['comment']) ) $and[] = 'idx_root>0';

        if ( $q = request('q') ) {
            if ( $qn = request('qn') ) {
                if ( $user = user($q) ) {
                    $ands[] = 'user_id=' . $user->get('id');
                }
            }
            else if ( request('qt') || request('qc') ) {
                $qt = request('qt');
                $qc = request('qc');
                $words = explode(' ', $q, 2);
                foreach( $words as $word ) {
                    $or = [];
                    if ( $qt ) $or[] = "`title` LIKE '%$word%'";
                    if ( $qc ) $or[] = "content_stripped__value LIKE '%$word%'";
                    $and[] = '(' . implode(' OR ', $or) .')';
                }
            }
            else {
                // no filtering
                $words = explode(' ', $q, 2);
                foreach( $words as $word ) {
                    $or = [];
                    $or[] = "`title` LIKE '%$word%'";
                    $or[] = "content_stripped__value LIKE '%$word%'";
                    $and[] = '(' . implode(' OR ', $or) .')';
                }
            }
        }
        if ( $and ) return implode(' AND ', $and);
        else return null;
    }


    public static function viewPostData() {
        if ( ! $post = PostData::preProcess(post_data(request('idx'))) ) error(-50119, "Post does not exist.");
        return Response::render([
            'template'=>'post.layout',
            'page'=>'post.view',
            'post'=>$post
        ]);
    }
}