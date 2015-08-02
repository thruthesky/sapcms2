<?php
namespace sap\src;
use sap\core\System\System;

class Theme {

    public static function script($filename=null)
    {
        global $theme;

        if ( empty($filename) ) {
            $class = Route::load()->class;
            $method = Route::load()->method;
            $filename = "$class.$method";
        }

        $variables = ['filename'=>$filename];
        call_hooks('template_script', $variables);

        $path = "theme/$theme/$variables[filename].html.php";
        if ( file_exists($path) ) return $path;

        $module = Route::load()->module;

        $path = null;
        if ( System::isCoreModule($module) ) $path = 'core/';
        $path .= "module/$module/template/$variables[filename].html.php";
        return $path;
    }

}

