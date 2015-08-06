<?php
use sap\core\Config\Config;
use sap\core\System\System;
use sap\core\User\User;
use sap\src\Database;
use sap\src\Entity;
use sap\src\Form;
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

function config_get($code) {
    return Config::load()->get($code);
}



function form_input($attr) {
    echo form::input($attr);
}




function user($field=null, $value='idx') {
    if ( $field === null ) return User::create();
    else return User::load($field, $value);
}

function config() {
    return Config::load();
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
            $value = Config::load()->get($code);
            break;
    }

    return $value;
}


function submit() {
    return Request::submit();
}

function user_count() {
    return Entity::query('user')->count();
}