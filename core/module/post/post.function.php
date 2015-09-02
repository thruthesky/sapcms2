<?php

use sap\core\post\post;
use sap\core\post\PostConfig;
use sap\core\post\PostData;
use sap\src\Route;

/**
 *
 * Returns an Item of PostConfig Entity.
 *
 *
 *
 *
 * @param null $field - is the field name
 *
 * @param null $value
 * @return PostConfig|bool
 */
function post_config($field=null, $value=null) {
    if ( $field && $value ) {
        return post_config()->load($field, $value);
    }
    else if ( $field ) {
        if ( is_numeric($field) ) return post_config()->load('idx', $field);
        else return post_config()->load('id', $field);
    }
    else return new PostConfig();
}




function is_post_page() {
    return segment(0) == 'post';
}
function is_post_config_page() {
    return segment(1) == 'config';
}

function is_post_edit_page() {
    return segment(1) == 'edit' || segment(2) == 'edit';
}




function post_data($idx=null) {
    if ( $idx ) {
        return post_data()->load('idx', $idx);
    }
    return new PostData();
}

function post() {
    return new post();
}

function url_post_edit() {
    return post::urlPostEdit();
}
function url_post_create() {
    return post::urlPostCreate();
}
function url_post_config() {
    return post::urlEditPostConfig();
}
function url_post_list() {
    return post::urlPostList();
}

function html_hidden_post_variables() {
    return post::getHttpVariablesAsHidden();
}
function url_post_comment_edit($idx) {
    return post::urlPostCommentEdit($idx);
}
function url_post_delete($idx=0) {
    return post::urlPostDelete($idx);
}


function display_files($files) {
    if ( empty($files) ) return null;
    $tag_imgs = [];
    $tag_files = [];
    foreach($files as $file) {
        $url = $file->url();
        $name = $file->get('name');
        if ( is_image($name) ) {
            $tag_imgs[] = "<div class='image'><img src='$url'></div>";
        }
        else {
            $tag_files[] = "<div class='attachment'><a href='$url'>$name</a></div>";
        }
    }
    array_walk($tag_files, 'display');
    array_walk($tag_imgs, 'display');
}


function is_post_admin() {
    if ( admin() ) return true;
    return false;
}

/**
 *
 * Returns true if the post is login user's post.
 *
 * @param $idx
 * @return bool
 * @code
 * $idx = request('idx');
 * if ( is_my_post($idx) ) { ... }
 *
 * $data = post_data($idx);
 * if ( ! is_my_post($data) ) return self::templateErrorNotYourPost();
 * @endcode
 */
function is_my_post($idx) {
    if ( is_numeric($idx) ) $post = post_data($idx);
    else if ( $idx instanceof PostData ) $post = $idx;
    if ( $post ) {
        return $post->get('idx_user') == my('idx');
    }
    return false;
}


function url_forum() {
    return "/post";
}