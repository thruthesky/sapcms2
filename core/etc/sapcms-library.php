<?php
use sap\core\Config\Config;
use sap\core\System\System;
use sap\src\Database;
use sap\src\Request;
use sap\src\Response;
use sap\src\Template;


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

function template($filename=null) {
    return Template::script($filename);
}


function theme_layout()
{
    global $theme;
    return "theme/$theme/layout.html.php";
}


function system_layout()
{
    return "core/module/system/template/layout.html.php";
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
function call_hooks($hook, &$args=[]) {
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

function get_last_included_file() {
    $arr = get_included_files();
    return array_pop($arr);
}

function get_sapcms_path($path) {
    $ds = DIRECTORY_SEPARATOR;
    $folders = ['core', 'module', 'theme'];
    foreach( $folders as $folder ) {
        if ( $n = strpos($path, "$ds$folder$ds") ) {
            $str = substr($path, $n + 1);
            if ( $ds != '/' ) $str = str_replace($ds, '/', $str);
            return $str;
        }
    }
    return null;
}

function add_url_internal_root(&$path) {
    if ( $path[0] == '/' ) {

    }
    else if ( strpos($path, 'http') === 0 ) {

    }
    else {
        $pre = Config::load()->get(URL_SITE);
        $path = $pre . $path;
    }
    return $path;
}


function add_css($filename=null) {
    if ( empty($filename) ) {
        $file = get_last_included_file();
        $path = get_sapcms_path($file);
        $path = str_replace("/template/", '/css/', $path);
        $path = str_replace(".html.php", '.css', $path);
    }
    else if ( strpos($filename, '/') === FALSE ) {
        $file = get_last_included_file();
        $path = get_sapcms_path($file);
        $path = str_replace("/template/", '/css/', $path);
        $pu = pathinfo($path);
        $path = str_replace($pu['basename'], $filename, $path);
    }
    else {
        $path = add_url_internal_root($filename);
    }
    Response::addCss($path);
}


function add_javascript($filename=null) {
    if ( empty($filename) ) {
        $file = get_last_included_file();
        $path = get_sapcms_path($file);
        $path = str_replace("/template/", '/js/', $path);
        $path = str_replace(".html.php", '.js', $path);
    }
    else if ( strpos($filename, '/') === FALSE ) {
        $file = get_last_included_file();
        $path = get_sapcms_path($file);
        $path = str_replace("/template/", '/js/', $path);
        $pu = pathinfo($path);
        $path = str_replace($pu['basename'], $filename, $path);
    }
    else {
        $path = add_url_internal_root($filename);
    }
    Response::addJavascript($path);
}


/**
 *
 * Returns current site address
 *
 *
 *
 * @return string
 *
 *  - it returns '/' on CLI.
 *
 *
 */
function get_current_url()
{
    if ( System::isCommandLineInterface() ) return '/';
    $s = &$_SERVER;
    $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
    $sp = strtolower($s['SERVER_PROTOCOL']);
    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
    $port = $s['SERVER_PORT'];
    $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
    $host = isset($s['HTTP_X_FORWARDED_HOST']) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    $uri = $protocol . '://' . $host . $s['REQUEST_URI'];
    $segments = explode('?', $uri, 2);
    $url = $segments[0];
    return $url;
}
