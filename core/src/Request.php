<?php
namespace sap\src;
class Request {
    static $storage = [];
    private static $request_uri = null;

    public static function get($k=null) {
        if ( empty(self::$storage) ) self::reset();
        if ( empty($k) ) return self::$storage;
        if ( isset(self::$storage[$k]) ) return self::$storage[$k];
        else return null;
    }

    public static function reset() {
        self::$storage = array_merge($_GET, $_POST);
        return self::$storage;
    }

    /**
     *
     * @param $n
     * @return bool
     */
    public static function segment($n) {
        $segment = self::getSegment();
        if ( isset($segment[$n]) ) return $segment[$n];
        else return FALSE;
    }






    /**
     * @param $k
     * @param $v
     *
     * @code Setting new variable for input
     *
        Request::set('module', 'Install');
        Request::set('class', 'Form');
        Request::set('method', 'Input');
     *
     * @endcode
     *
     * @code Setting new variable and let it adjust.
     *  Request::set(HTTP_VAR_ROUTE, "Install.Form.Input");
     * @endcode
     *
     */
    public static function set($k, $v)
    {
        self::$storage[$k] = $v;
    }


    public static function module($module_name)
    {
        return Route::load()->module == $module_name;
    }

    /**
     *
     * Returns TRUE
     *  - if the form is submitted with the variable of'mode' and with value of 'submit'
     *  - if the form is submitted in POST method.
     *
     * @return bool
     */
    public static function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') return TRUE;
        else return self::get('mode') == 'submit';
    }

    /**
     *
     * @note it parses only once.
     *
     * @return array|null
     */
    private static function getSegment()
    {
        if ( self::$request_uri === null && isset($_SERVER['REQUEST_URI']) ) {
            if ( isset($_SERVER['REQUEST_URI']) ) {
                $arr = explode('?', $_SERVER['REQUEST_URI'], 2);
                $route = $arr[0];
                self::$request_uri = $route;
                self::$request_uri = trim(self::$request_uri , '/');
                self::$request_uri = explode('/', self::$request_uri );
            }
        }
        return self::$request_uri;
    }

}
