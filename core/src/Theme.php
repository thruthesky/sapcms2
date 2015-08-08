<?php
namespace sap\src;
use sap\core\System\System;

class Theme {

    public static function script($filename=null)
    {

        // theme template check

        global $theme;
        if ( empty($filename) ) {
            // $module = Route::load()->module;
            $class = Route::load()->class;
            $method = Route::load()->method;
            $filename = "$class.$method";
        }


        $variables = ['filename'=>$filename];
        $variables['path'] = "theme/$theme/template/$variables[filename].html.php";
        //print_r($variables);
        hook('theme_script', $variables);

        if ( file_exists($variables['path']) ) return $variables['path'];
        else return FALSE;
    }

}

