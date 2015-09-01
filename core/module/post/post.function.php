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
    return segment(1) == 'edit';
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


function display_file($file) {
    $imgs = [];
    $files = [];
    $url = $file->url();
    $name = $file->get('name');
    if ( is_image($name) ) {
        $imgs[] = "<img src='$url'>";
    }
    else {
        $files[] = "<a href='$url'>$name</a>";
    }
    array_walk($files, 'display');
    array_walk($imgs, 'display');
}
