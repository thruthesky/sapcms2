<?php
use sap\core\Config\Config;
use sap\core\Install\Install;
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

/**
 * Echo input $data
 * @param $data
 * @note Use this function on callback.
 *      - since echo is not a function, it cannot be used as callback function.
 * @code
 * array_walk($files, 'display');
 * array_walk($imgs, 'display');
 * @endcode
 */
function display($data) {
    echo $data;
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

// Alias of template::script()
function template($filename=null, $module=null) {
    return Template::script($filename, $module);
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

// alias of system::error()
function error($code, $array_kvs=[]) {
    return System::error($code, $array_kvs);
}

/**
 * @deprecated use setError();
 * @param $code
 * @param $message
 * @return mixed
 */
function set_error($code, $message) {
    return setError($code, $message);
}

/**
 * alias of System::setError();
 *
 * @Attention setError() and error() are different.
 *
 * @param $code
 * @param $message
 * @return mixed
 */
function setError($code, $message) {
    return System::setError($code, $message);
}


/**
 * alias of system::getError();
 * @return mixed
 */
function getError() {
    return System::getError();
}
/**
 * alias of system::getError();
 * @return mixed
 */
function getErrorString() {
    return System::getErrorString();
}



function ip() {
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
}
function domain() {
    return domain_name();
}

function user_agent() {
    return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
}

/**
 * @return null
 * @code
 * ->set('ip', ip())
->set('referer', referer())
->set('user_agent', user_agent())

 * @endcode
 */
function referer() {
    return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
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
 *      - Returns null if the path is not a module script.
 *
 * @param $path
 *
 *
 * @return null
 */
function get_module_from_path($path) {
    if ( DIRECTORY_SEPARATOR != '/' ) $path = str_replace(DIRECTORY_SEPARATOR, '/', $path);

    if ( strpos($path, 'core/module/') !== false ) {
        $arr = explode('core/module/', $path);
        if ( isset($arr[1]) ) {
            $arr = explode('/', $arr[1]);
            return $arr[0];
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
        $path = remove_ending_slash($url) . $path;
    }
    else if ( strpos($path, 'http') === 0 ) {

    }
    else if ( strpos($path, '//') === 0 ) {

    }
    else {
        if ( ! Install::check() ) $url = '/';
        else {
            $url = config(URL_SITE);
            if ( empty($url) ) $url = get_current_domain_url(); //
            //if ( empty($url) ) $url = '/'; // if CLI run, $url will be emtpy.
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
 * Returns current site address including Querys
 *
 * @return string
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
    //$segments = explode('?', $uri, 2);
    //$url = $segments[0];
    return $uri;
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




function widget($widget_name, $widget=null) {
    $path = "widget/$widget_name/$widget_name.php";
    if ( ! file_exists($path) ) {
        $module = Request::module();
        if ( is_core_module($module) ) {
            $path = PATH_INSTALL . "/core/module/$module/widget/$widget_name/$widget_name.php";
        }
        else $path = PATH_INSTALL . "/module/$module/widget/$widget_name/$widget_name.php";
    }
    include $path;
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
    if ( System::isCommandLineInterface() ) return ;
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
    if ( System::isCommandLineInterface() ) return ;

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
function remove_ending_slash($url) {
    return rtrim($url,"/");
}


/**
 * Returns the no of the current page from URL.
 *
 *      - the mininum number is always 1.
 *
 * @return array|int|null
 */
function page_no() {
    $page_no = Request::get('page_no');
    if ( empty($page_no) ) return 1;
    else if ( $page_no <= 0 ) return 1;
    else return $page_no;
}




function date_short($stamp=0) {
    if ( empty($stamp) ) $stamp = time();
    if ( date('d', $stamp) == date('d') ) {
        return date('h:i a', $stamp);
    }
    else {
        return date('Y-m-d', $stamp);
    }
}


/**
 * @param $option
 * @param null $text
 * @return string
 *
 * @code
 * echo html_row([
'caption' => 'Now',
'text' => date('r')
]);
 * @endcode
 *
 * @code Caption and Text
 *      echo html_row('Your Selection', config(USER_TIMEZONE_3));
 * @endcode
 *
 *
 * @code Caption and HTML Element
 *
<?php echo html_row([
'class' => 'title',
'caption' => 'TITLE',
'text' => html_input([
'name' => 'title',
'placeholder' => 'Input title'
]),
]); ?>
 *
 * @endcode
 *
 */
function html_row($option, $text=UNDEFINED) {
    if ( $text == UNDEFINED ) $o = $option;
    else {
        $o['caption'] = $option;
        $o['text'] = $text;
    }
    $re = "<div class='row";
    if ( isset($o['class']) ) $re .= " $o[class]";
    $re .= "'>";
    if ( isset($o['caption']) ) {
        $re .= "<div class='caption'>$o[caption]</div>";
    }
    if ( isset($o['text']) ) {
        $re .= "<div class='text'>$o[text]</div>";
    }
    $re .= "</div>";
    return $re;
}


/**
 * @param $o
 *      - $o['type'] - is the type of FORM INPUT element. if it is not set, default is 'text'
 * @return string
 */
function html_input($o) {
    $re = "<input";
    if ( isset($o['type']) ) $re .= " type='$o[type]'";
    else  $re .= " type='type'";
    if ( isset($o['id']) ) $re .= " id='$o[id]'";
    if ( isset($o['class']) ) $re .= " class='$o[class]'";
    if ( isset($o['name']) ) $re .= " name='$o[name]'";
    if ( isset($o['value']) ) $re .= " value='$o[value]'";
    if ( isset($o['placeholder']) ) $re .= " placeholder='$o[placeholder]'";
    $re .= ">";
    return $re;
}

function html_password($o) {
    $o['type'] = 'password';
    return html_input($o);
}

/**
 * @param $o
 * @return string
 * @code
 *      echo html_hidden(['name'=>'idx', 'value'=>$user->get('idx')]);
 * @endcode
 */
function html_hidden($o) {
    $o['type'] = 'hidden';
    return html_input($o);
}

function html_select($o) {
    $re = "<select";
    if ( isset($o['id']) ) $re .= " id='$o[id]'";
    if ( isset($o['class']) ) $re .= " class='$o[class]'";
    if ( isset($o['name']) ) $re .= " name='$o[name]'";
    $re .= ">";

    foreach( $o['options'] as $key => $value ) {
        //condition added by benjamin for selected
        $selected = '';
        if( isset( $o['selected']  ) ){
            if( $o['selected'] == $key ) $selected = ' selected';
        }
        $re .= "<option value='$key'$selected>$value</option>";
    }
    $re .= "</select>";
    return $re;
}

function html_textarea($o) {
    $re = "<textarea";
    if ( isset($o['id']) ) $re .= " id='$o[id]'";
    if ( isset($o['class']) ) $re .= " class='$o[class]'";
    if ( isset($o['name']) ) $re .= " name='$o[name]'";
    if ( isset($o['placeholder']) ) $re .= " placeholder='$o[placeholder]'";
    $re .= ">";
    if ( isset($o['value']) ) $re .= $o['value'];
    $re .= "</textarea>";
    return $re;
}


function html_select_timezone($form_name, $value=null) {
    $regions = array(
        'Africa' => DateTimeZone::AFRICA,
        'America' => DateTimeZone::AMERICA,
        'Antarctica' => DateTimeZone::ANTARCTICA,
        'Aisa' => DateTimeZone::ASIA,
        'Atlantic' => DateTimeZone::ATLANTIC,
        'Europe' => DateTimeZone::EUROPE,
        'Indian' => DateTimeZone::INDIAN,
        'Pacific' => DateTimeZone::PACIFIC
    );

    $timezones = array();
    foreach ($regions as $name => $mask)
    {
        $zones = DateTimeZone::listIdentifiers($mask);
        foreach($zones as $timezone)
        {
            // Lets sample the time there right now
            $time = new DateTime(NULL, new DateTimeZone($timezone));

            // Us dumb Americans can't handle millitary time
            $ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';

            // Remove region name and add a sample time
            $timezones[$name][$timezone] = substr($timezone, strlen($name) + 1) . ' - ' . $time->format('H:i') . $ampm;
        }
    }


// View


    $re = "<select name='$form_name'>";
    $re .= '<option value="">Select Timezone</option>';

    foreach($timezones as $region => $list)
    {
        $re .= '<optgroup label="' . $region . '">' . "\n";
        foreach($list as $timezone => $name)
        {
            $re .= '<option value="' . $timezone . '"';
            if ( $timezone == $value ) $re .= " selected=1";
            $re .= '>' . $name . '</option>' . "\n";
        }
        $re .= '<optgroup>' . "\n";
    }
    $re .= '</select>';
    return $re;
}


/**
 *
 * Cut UTF-8 string
 *
 * @param $str
 * @param $len
 * @param string $suffix
 * @return string
 */
function strcut($str, $len, $suffix="")
{
    $s = substr($str, 0, $len);
    $cnt = 0;
    for ($i=0; $i<strlen($s); $i++)
        if (ord($s[$i]) > 127)
            $cnt++;
    $s = substr($s, 0, $len - ($cnt % 3));
    if (strlen($s) >= strlen($str))
        $suffix = "";
    return $s . $suffix;
}



/**
 * Returns "Escaped String" to use in javascript alert()
 *
 *      - it escapes single quote, line feed, etc.
 *
 * @param $msg
 * @return mixed
 */
function jsMessage($msg)
{
    $msg = str_replace("\\", "\\\\", $msg);
    $msg = str_replace("\n", "\\n", $msg);
    $msg = str_replace("\r", "\\r", $msg);
    $msg = str_replace("\"", "'", $msg);

    return $msg;
}


/**
 *
 * Redirect PAGE into another.
 *
 * @ATTENTION It ECHOes to browser directly meaning you may need to terminate right after you call this function.
 * @ATTENTION it displays UTF-8 HTML structure.
 *
 *
 * @param $url
 * @param null $message - is the message to alert
 * @param null $target - is the target window or frame to open the PAGE of URL
 * @return int
 */
function jsGo($url, $message=NULL, $target=NULL) {
    if ( $message ) $message = jsMessage($message);
    $out = "<!doctype html><html><head><meta charset='utf-8'></head><body>";
    $out .= "<script>";
    if ( $message ) $out.= "alert(\"$message\");";
    if ( $target ) $target = "$target.";
    $out.= "
			{$target}location.href='$url';
			</script>
		";
    $out .= "</body></html>";
    echo $out;
    return OK;
}

/**
 * Prints out javascript alert() with a message.
 * @param $message
 * @param bool|false $header - if it is true, it echoes UTF-8 header.
 * @return int
 */
function jsAlert($message, $header=true)
{
    if ( $message ) $message = jsMessage($message);
    if ( $message ) {
        if ( $header ) echo "<!doctype html><html><head><meta charset='utf-8'></head><body>";
        echo "<script>";
        echo "alert(\"$message\");";
        echo "</script>";
        if ( $header ) echo "</body></html>";
    }
    return OK;
}

/**
 * Prints out "javascript history go back" to browser.
 *
 * @Attention it prints out HTML5 UTF-8 basic structure.
 * @Attention You may need to terminate the RUN after this call.
 *
 * @param $message
 * @param bool|true $header
 * @return int
 */
function jsBack($message, $header=true)
{
    if ( $header ) echo "<!doctype html><html><head><meta charset='utf-8'></head><body>";
    if ( $message ) $message = jsMessage($message);
    echo "<script>";
    if ( $message ) echo "alert(\"$message\");";
    echo "
			history.go(-1);
			</script>
		";
    if ( $header ) echo "</body></html>";
    return OK;
}

function url_go_back() {
    return "javascript:history.go(-1);";
}

function system_runtime() {
    global $time_start_script;
    $time_end = microtime(true);
    $time = $time_end - $time_start_script;
    return round($time, 2);
}



function error_get_last_message() {
    $error = error_get_last();
    if ( $error ) return "$error(type) $error[message]";
    else return null;
}

/**
 * Tells whether the input file name is image
 */
function is_image($filename)
{
    $mime = get_mime_type($filename);
    return strpos($mime, "image") !== false;
}

function get_mime_type($file)
{
    $mime_types = array(
        "pdf" => "application/pdf",
        "exe" => "application/octet-stream",
        "zip" => "application/zip",
        "docx" => "application/msword",
        "doc" => "application/msword",
        "xls" => "application/vnd.ms-excel",
        "ppt" => "application/vnd.ms-powerpoint",
        "gif" => "image/gif",
        "png" => "image/png",
        "jpeg" => "image/jpg",
        "jpg" => "image/jpg",
        "mp3" => "audio/mpeg",
        "wav" => "audio/x-wav",
        "mpeg" => "video/mpeg",
        "mpg" => "video/mpeg",
        "mpe" => "video/mpeg",
        "mov" => "video/quicktime",
        "avi" => "video/x-msvideo",
        "3gp" => "video/3gpp",
        "css" => "text/css",
        "jsc" => "application/javascript",
        "js" => "application/javascript",
        "php" => "text/html",
        "htm" => "text/html",
        "html" => "text/html"
    );
    $arr = explode('.', $file);
    $ext = end($arr);
    $extension = strtolower($ext);
    if ( isset($mime_types[$extension]) ) return $mime_types[$extension];
    else return "application/octet-stream";
}


/**
 * @return bool|mixed|null
 */
function url_site() {
    return sysconfig(URL_SITE);
}
