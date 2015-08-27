<?php
namespace sap\src;
use sap\core\system\System;
use sap\core\system\SystemController;

class Module {

    private static $core_modules = ['admin', 'config', 'front', 'install', 'system', 'user'];

    private static $variables = [];


    public static function script($filename=null)
    {

        $module = Route::load()->module;
        $path_module = self::path($module);

        if ( empty($filename) ) {
            $class = Route::load()->class;
            $method = Route::load()->method;
            $filename = "$class.$method";
        }


        $variables['path'] = "$path_module/template/$filename.html.php";
        hook('module_script', $variables);

        return $variables['path'];

    }

    private static function path($module)
    {
        if ( self::isCoreModule($module) ) return "core/module/$module";
        else return "module/$module";
    }

    public static function isCoreModule($module) {
        return in_array($module, self::getCoreModules());
    }
    public static function getCoreModules()
    {
        return self::$core_modules;
    }


    /**
     *
     * Runs the module class method and returns the result
     *
     * @param null $route
     * @return mixed
     *
     */
    public static function run($route=null)
    {

        if ( empty($route) ) {
            $module = Route::load()->module;
            $class = Route::load()->class;
            $method = Route::load()->method;
        }
        else {
            $match = Route::match($route);
            list($module, $class, $method) = explode("\\", $match);
        }

        if ( System::isEnabled($module) ) {
            $core = is_core_module($module) ? "core\\" : null;
            $name = "sap\\{$core}$module\\$class";
            System::log("Module::run() => $name::$method ()");
            return $name::$method();
        }
        else {
            return SystemController::moduleNotEnabled();
        }

    }


    /**
     * @param $variables
     */
    public static function setVariables($variables)
    {
        self::$variables = $variables;
    }
    public static function getVariables()
    {
        return self::$variables;
    }

}

