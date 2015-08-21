<?php
namespace sap\post;
use sap\src\Database;
use sap\src\Response;

class post {
    public static function index() {
        return Response::renderSystemLayout();
    }
    public static function admin() {
        return Response::renderSystemLayout();
    }


    public static function configCreate() {
        return Response::renderSystemLayout(['template'=>'post.config.create']);
    }


    public static function configCreateSubmit() {
        if ( post_config(request('id')) ) {
            error(-50100, "The post config ID is already exists.");
            return Response::renderSystemLayout(['template'=>'post.config.create']);
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
        return Response::render(['template'=>'post.config.list']);
    }

    public static function listPostData() {
        $config = post_config()->getCurrent()->get();
        $posts = self::searchPostData();
        return Response::render([
            'template'=>'post.data.list',
            'config' => $config,
            'posts' => $posts,
        ]);
    }

    public static function editPostData() {
        return Response::render(['template'=>'post.data.edit']);
    }

    public static function editSubmitPostData() {
        if ( self::validateEditSubmit() ) {
            return Response::render(['template'=>'post.data.edit']);
        }

        $config = post_config( request('id') );
        $data = post_data();
        $data->set('idx_config', $config->get('idx'));
        $data->set('title', request('title'));
        $data->set('content', request('content'));
        $data->save();

        $post = post_data($data->idx)->getFields();


        return Response::render([
            'template' => 'post.data.view',
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

    private static function searchPostData($option=[])
    {
        $new_posts = [];
        $posts = post_data()->rows(null, '*');
        foreach ( $posts as $post ) {
            if ( $post['idx_user'] ) {
                $post['user'] = user($post['idx_user']);
            }
            else $post['user'] = FALSE;
            $new_posts[] = $post;
        }
        return $new_posts;
    }

}