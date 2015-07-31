<?php
use sap\core\Database;
use sap\core\System;
use sap\core\Request;

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
    global $theme;
    if ( empty($filename) ) $filename = Request::getRoute();
    call_hooks(__METHOD__, $filename);
    $path = "theme/$theme/$filename.html.php";
    if ( file_exists($path) ) return $path;
    $module = Request::get('module');
    $path = null;
    if ( System::isCoreModule($module) ) $path = 'core/';
    $path .= "module/$module/template/$filename.html.php";
    return $path;
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
    if ( empty($module) ) $module = sap\core\Request::get('module');
    return in_array($module, $GLOBALS['core_modules']);
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