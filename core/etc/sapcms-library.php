<?php
use sap\core\Config\Config;
use sap\core\System\System;
use sap\core\User\User;
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


function error($code, $array_kvs=[]) {
    return System::error($code, $array_kvs);
}
function get_error() {
    return System::getError();
}


function ip() {
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
}

function user_agent() {
    return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
}

// $hooks = [];
/*
function register_hook($hook, $func) {
    global $hooks;
    $hooks[$hook][] = $func;
}
*/
/*
function call_hooks($hook, &$args=[]) {
    global $hooks;
    if ( isset($hooks[$hook]) ) {
        foreach( $hooks[$hook] as $func ) {
            $func($args);
        }
    }
}
*/


function hook($hook_name, &$variables=[]) {
    foreach( System::getModuleLoaded() as $module ) {
        $func = "hook_{$hook_name}_$module";
        if ( function_exists($func) ) $func($variables);
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
    if ( DIRECTORY_SEPARATOR != '/' ) $path = str_replace(DIRECTORY_SEPARATOR, '/', $path);
    $folders = ['core', 'module', 'theme', 'widget'];
    foreach( $folders as $folder ) {
        if ( $n = strpos($path, "/$folder/") ) {
            $str = substr($path, $n + 1);
            return $str;
        }
    }
    return null;
}


/**
 *
 * Returns 'module-name' form file path.
 *
 * @param $path
 *
 *
 * @return null
 */
function get_module_from_path($path) {
    if ( DIRECTORY_SEPARATOR != '/' ) $path = str_replace(DIRECTORY_SEPARATOR, '/', $path);

    if ( strpos($path, 'core/') !== false ) {
        $arr = explode('core/', $path);
        if ( isset($arr[1]) ) {
            $arr = explode('/', $arr[1]);
            return $arr[1];
        }
    }
    else if ( strpos($path, 'module/') !== false ) {
        $arr = explode('module/', $path);
        if ( isset($arr[1]) ) {
            $arr = explode('/', $arr[1]);
            return $arr[0];
        }
    }
    return null;
}



/**
 *
 * This makes the $path into a complete URL.
 *
 * - if the System is not installed yet, it only returns the url begin with '/'.
 *
 * @param $path
 * @return string
 *
 * @see buildguide installation
 */
function url_complete(&$path) {
    if ( $path[0] == '/' ) {
        $url = config(URL_SITE);
        if ( empty($url) ) $url = get_current_domain_url();
        $url = rtrim($url,"/");
        $path = $url . $path;
    }
    else if ( strpos($path, 'http') === 0 ) {

    }
    else {
        if ( ! System::isInstalled() ) $url = '/';
        else {
            $url = config(URL_SITE);
            if ( empty($url) ) $url = get_current_domain_url();
        }
        $path = $url . $path;
    }
    return $path;
}

/*
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
        $path = url_complete($filename);
    }
    Response::addCss($path);
}
*/

function add_css($filename=null, $base=null) {
    if ( empty($base) ) $base = get_last_included_file();
    return Response::addCss($filename, $base);
}

function add_javascript($filename=null, $base=null) {
    if ( empty($base) ) $base = get_last_included_file();
    return Response::addJavascript($filename, $base);
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
    return add_ending_slash($url);
}

/**
 * Returns URL of domain without Path and Query String
 *
 * @note Return example
 *  - https://www.abc:8080/
 *  - http://aaa.bbb.ccc:1234/
 *
 *
 * @return string
 */
function get_current_domain_url() {
    if ( System::isCommandLineInterface() ) return '/';
    $s = &$_SERVER;
    $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
    $sp = strtolower($s['SERVER_PROTOCOL']);
    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
    $port = $s['SERVER_PORT'];
    $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
    $host = isset($s['HTTP_X_FORWARDED_HOST']) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    $uri = $protocol . '://' . $host . '/';
    return add_ending_slash($uri);
}




function widget($widget_name) {
    include "widget/$widget_name/$widget_name.php";
}

/**
 * @param $plain_text_password
 * @return string
 */
function encrypt_password($plain_text_password) {
        return md5($plain_text_password);
}



/**
 * Returns domain in lower character.
 *
 * It includes all the domain ( 2nd, 3rd )
 *
 * @Attention it does not includes port.
 *
 * @code Return example
abc.123.456.com
www.abc.com
abc.com
 * @endcode

 */

function domain_name()
{
    if ( isset( $_SERVER['HTTP_HOST'] ) ) {
        $domain = $_SERVER['HTTP_HOST'];
        $domain = strtolower($domain);
        if ( strpos($domain, ':') ) list ( $domain, $trash ) = explode(':', $domain, 2);
        return $domain;
    }
    else return NULL;
}

/**
 *
 * @brief Saves key and value into cookie.
 * @note
 *  You can save NULL, empty string, 0
 * @param $k - the key
 * @param null $v - the value
 * @param int $exp - the time to be expire. the default is 1 year.
 * @param $domain - the domain that this cookie will be available.
 *      - if $domain is null, it will be available for all subdomain.
 *
 */
function session_set($k, $v=null, $exp=null, $domain=null)
{
    if ( empty($exp) ) $exp = time() + 365 * 24 * 60 * 60;
    $dir = '/';
    if ( empty($domain) ) $domain = domain_name();

    /// cookie for that domain olnly
    setcookie($k, $v, $exp, $dir, $domain);

    /// cookie for all sub domain.
    $domains = explode('.',$domain);
    $count = count($domains) - 1;
    for ( $i=0; $i < $count; $i ++ ) {
        $sub_domain = '.' . implode('.', $domains);
        array_shift($domains);
        setcookie($k, $v, $exp, $dir, $sub_domain);
    }
}


function session_delete($k, $domain=NULL)
{
    $dir = '/';
    if ( empty($domain) ) $domain = domain_name();
    setcookie($k, NULL, time()-3600*24*30, $dir, $domain);



    /// cookie for all sub domain.
    $domains = explode('.',$domain);
    $count = count($domains) - 1;
    for ( $i=0; $i < $count; $i ++ ) {
        $sub_domain = '.' . implode('.', $domains);
        array_shift($domains);
        setcookie($k, NULL, time()-3600*24*30, $dir, $sub_domain);
    }



}

function session_get($k)
{
    if ( isset($_COOKIE[$k]) ) return $_COOKIE[$k];
    else return NULL;
}


/**
 * Adds slash(/) at the end of the string if it is not end with slash(/)
 * @param $path
 * @return string
 */
function add_ending_slash($path) {
    $last_char = substr($path, strlen($path)-1, 1);
    if ( $last_char != '/' ) $path .= '/';
    return $path;
}