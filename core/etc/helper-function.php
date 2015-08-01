<?php
use sap\src\Config;
use sap\src\Database;
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

function config_get($code, $return_entity=false) {
    return Config::load()->get($code, $return_entity);
}

