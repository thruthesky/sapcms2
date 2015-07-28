<?php
namespace sap\core;
class Route {
    /**
     * @param $module
     * @param null $class
     * @param string $method
     * @return string
     *
     * @code
     * core\Response::redirect(core\Route::create("Install.Form.Input"));
     * sap\core\Response::redirect(sap\core\Route::create('Install', 'Form', 'Input'));
     * @code
     */
    public static function create($module, $class=null, $method='defaultController') {
        if ( $class ) {
            return '?' . HTTP_VAR_ROUTE . "=$module.$class.$method";
        }
        else {
            return '?' . HTTP_VAR_ROUTE . '=' . $module;
        }
    }
}