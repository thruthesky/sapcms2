<?php

use sap\post\post;
use sap\post\PostConfig;
use sap\post\PostData;
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
    if ( $idx = request('idx') ) return "/post/edit?idx=$idx";
    else if ( $id = request('id') ) return "/post/edit?id=$id";
    else return null;
}