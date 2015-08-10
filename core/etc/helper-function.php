<?php
use sap\core\Config\Config;
use sap\core\System\System;
use sap\core\User\User;
use sap\src\Database;
use sap\src\Entity;
use sap\src\Form;
use sap\src\Meta;
use sap\src\Request;
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


function db_row($table, $cond, $field='*') {
    return Database::load()->row($table, $cond, $field);
}

function db_delete($table, $cond) {
    return Database::load()->delete($table, $cond);
}


function form_input($attr) {
    echo form::input($attr);
}




function system_config($code) {

    $value = null;
    switch( $code ) {
        case 'database' :
            $value = System::getDatabaseConfiguration();
            break;
        case '' :
            break;
        default :
            $value = config()->get($code);
            break;
    }

    return $value;
}


function submit() {
    return Request::submit();
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


function get_login_user() {
    $id = session_get('user-id');
    $session_id = session_get('user-session-id');
    if ( empty($id) || empty($session_id) ) return FALSE;

    $user = user('id', $id);
    if ( empty($user) ) return FALSE;

    if ( $session_id == User::getUserSessionID($user) ) return $user;
    else return FALSE;
}

function login($field=null) {
    $user = get_login_user();
    if ( $user ) {
        if ( $field ) return $user->get($field);
        else return $user;
    }
    else return FALSE;
}
function my($field=null) {
    return login($field);
}


function system_log($msg) {
    System::log($msg);
}