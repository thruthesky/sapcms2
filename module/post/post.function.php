<?php

use sap\post\PostConfig;
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
        if ( is_numeric($field) ) return post_config($field);
        else return post_config($field, $value);
    }
    else return new PostConfig();
}


function is_post_page() {
    return segment(0) == 'post';
}
function is_post_config_page() {
    return segment(1) == 'config';
}