<?php
namespace sap\src;
class Request {
    static $storage = [];
    public static function get($k) {
        if ( empty(self::$storage) ) self::input();
        if ( isset(self::$storage[$k]) ) return self::$storage[$k];
        else return null;
    }
    public static function getRoute()
    {
        return self::get(HTTP_VAR_ROUTE);
    }
    public static function input()
    {
        if ( self::$storage ) return self::$storage;
        self::$storage = array_merge($_GET, $_POST);
        self::$storage = self::adjustInput(self::$storage);
        return self::$storage;
    }

    private static function adjustInput(array & $input)
    {
        if ( isset($input[ HTTP_VAR_ROUTE ]) ) {
            $arr = explode('.', $input[ HTTP_VAR_ROUTE ], 3);
            $input['module'] = isset($arr[0]) ? $arr[0] : DEFAULT_MODULE;
            $input['class'] = isset($arr[1]) ? $arr[1] : DEFAULT_CLASS;
            $input['method'] = isset($arr[2]) ? $arr[2] : DEFAULT_CONTROLLER;
        }
        else {
            $input[ HTTP_VAR_ROUTE ] = DEFAULT_MODULE . '.' . DEFAULT_CLASS . '.' . DEFAULT_CONTROLLER;
            $input['module'] = DEFAULT_MODULE;
            $input['class'] = DEFAULT_CLASS;
            $input['method'] = DEFAULT_CONTROLLER;
        }
        return $input;
    }

    public static function getAll()
    {
        return self::input();
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
        self::$storage = self::adjustInput(self::$storage);
    }


    public static function isPageInstall()
    {
        return self::get('module') == 'Install';
    }

}
