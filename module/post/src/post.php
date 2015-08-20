<?php
namespace sap\post;
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
        return Response::render(['template'=>'post.data.list']);
    }

    public static function editPostData() {
        return Response::render(['template'=>'post.data.edit']);
    }

}