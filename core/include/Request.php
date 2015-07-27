<?php
class Request {
    static $storage = [];
    public static function get($k) {
        if ( empty(self::$storage) ) self::input();
        if ( isset(self::$storage[$k]) ) return self::$storage[$k];
        else return null;
    }
    public static function input()
    {
        if ( self::$storage ) return self::$storage;
        self::$storage = array_merge($_GET, $_POST);
        self::$storage = self::adjustInput(self::$storage);
        return self::$storage;
    }
    public static function install() {
        return self::get('module') == 'install';
    }

    private static function adjustInput(array & $input)
    {
        if ( isset($input['act']) ) {
            $arr = explode('.', $input['act'], 2);
            $input['module'] = isset($arr[0]) ? $arr[0] : null;
            $input['action'] = isset($arr[1]) ? $arr[1] : null;
        }
        return $input;
    }
}