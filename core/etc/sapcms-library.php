<?php
use sap\core\System\System;
use sap\src\Database;
use sap\src\Request;
use sap\src\Theme;


function di($obj) {
    echo "<pre>";
    print_r($obj);
    echo "</pre>";
}

function beautify($obj) {
    di($obj);
}

function systeminfo() {
    $db = Database::load();
    $info = [];
    $info['database'] = $db->type;
    $info['php'] = PHP_VERSION;
    return $info;
}
function theme_script($filename=null)
{
    return Theme::script($filename);
}


function module_script()
{
    return System::get()
        ->module()
        ->script();
}


function theme_layout()
{
    global $theme;
    return "theme/$theme/layout.html.php";
}


function is_core_module($module=null) {
    if ( empty($module) ) $module = Request::get('module');
    return in_array($module, System::getCoreModules());
}

function dog($msg) {
    System::log($msg);
}

function ip() {
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
}

function user_agent() {
    return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
}

$hooks = [];
function register_hook($hook, $func) {
    global $hooks;
    $hooks[$hook][] = $func;
}
function call_hooks($hook, &$args) {
    global $hooks;
    if ( isset($hooks[$hook]) ) {
        foreach( $hooks[$hook] as $func ) {
            $func($args);
        }
    }
}


function get_error_message($code) {
    global $error_message;
    return isset($error_message[$code]) ? $error_message[$code] : $code;
}