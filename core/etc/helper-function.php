<?php
use sap\core\config\Config;
use sap\core\system\System;
use sap\core\user\User;
use sap\src\Database;
use sap\src\Entity;
use sap\src\Form;
use sap\src\jQM;
use sap\src\Meta;
use sap\src\Module;
use sap\src\Request;
use sap\src\Route;
use sap\src\SQL;


function db_and() {
    return SQL::where();
}

function db_or() {
    return SQL::where('OR');
}

function db_cond($name, $value, $exp='=')
{
    return SQL::where()
        ->condition($name, $value, $exp);
}


function db_insert($table, $fields) {
    $db = Database::load();
    return $db->insert($table, $fields);
}

function db_update($table, $fields, $cond) {
    $db = Database::load();
    return $db->update($table, $fields, $cond);
}


function db_row($table, $cond=null, $field='*') {
    return Database::load()->row($table, $cond, $field);
}

function db_delete($table, $cond) {
    return Database::load()->delete($table, $cond);
}


function module() {
    return new Module();
}

/**
 * Returns System Configuration Value
 *
 * @Attention the difference between config() and sysconfig() is that,
 *      sysconfig() wraps config() and it will return default values
 *      if config() has no value or proper value.
 *
 *
 * @param $code
 * @return bool|mixed|null
 */
function sysconfig($code) {

    $value = null;
    switch( $code ) {
        case 'database' :
            return System::loadDatabaseConfiguration();
        case NO_ITEM :
            if ( $no = config(NO_ITEM) ) return $no;
            else return DEFAULT_NO_ITEM;
        case NO_PAGE :
            if ( $no = config(NO_PAGE) ) return $no;
            else return DEFAULT_NO_PAGE;
        case URL_SITE :
            if ( $value = config(URL_SITE) ) return $value;
            return '/';
        default :
            return $value = config()->value($code);
    }
}


function submit() {
    return Request::submit();
}

/**
 *
 * Returns the value of the HTTP input. If the value is empty(null), then it returns the default.
 *
 * @param null $key
 * @param null $default
 * @return array|null
 */
function request($key=null, $default=null) {
    if ( empty($key) ) return Request::get();
    else {
        $value = Request::get($key);
        if ( $value === null ) return $default;
        else return $value;
    }
}



function segment($n) {
    return Request::segment($n);
}

/**
 *
 * Returns route or Add route
 *
 * @param null $route
 * @param null $controller
 * @return null|Route
 */
function route($route=null, $controller=null) {
    if ( $route === null ) {
        return Route::load();
    }
    else {
        return Route::add($route, $controller);
    }
}




/**
 * @return mixed
 */
function user_count() {
    return user()->count();
}

function entity($table_name=null) {
    return new Entity($table_name);
}

function meta($table_name) {
    return new Meta($table_name);
}


/**
 * @param null $field
 * @return array|bool|null|User
 *
 * @code
 * login('idx')
 * $data->set('idx_user', login('idx'));
 * @endcode
 */
function login($field=null) {
    $user = user()->getCurrent();
    if ( $user ) {
        if ( $field ) return $user->get($field);
        else return $user;
    }
    else return FALSE;
}
function my($field=null) {
    return login($field);
}

/**
 *
 * Returns TRUE if the login user is admin.
 *
 * @return bool
 *
 *
 * @refer buildguide User
 */
function admin() {
    $admin_id = config()->value('admin');
    return my('id') == $admin_id;
}




function system_log($msg) {
    System::log($msg);
}



function jqm() {
    return new jQM();
}

function errorHandler() {
    return new \sap\src\ErrorHandler();
}


/**
 * @ATTENTION This function must be here so that this function can be used in bootstrap
 * @param null $code
 * @param null $value
 * @param int $target
 * @return $this|mixed|Config
 */
function config($code=null, $value=null, $target=0) {
    if ( $value || $target ) {
        return config()->set($code, $value, $target);
    }
    else if ( $code ) {
        return config()->value($code);
    }
    else return new Config();
}
