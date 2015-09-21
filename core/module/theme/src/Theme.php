<?php
namespace sap\core\Theme;
use sap\src\Route;

class Theme {
    public static function script($filename=null)
    {
        // theme template check
        if ( empty($filename) ) {
            // $module = Route::load()->module;
            $class = Route::load()->class;
            $method = Route::load()->method;
            $filename = "$class.$method";
        }
        $variables = ['filename'=>$filename];
        $theme = sys()->getTheme();
        //di($theme);
        $variables['path'] = "theme/$theme/template/$variables[filename].html.php";
        //print_r($variables);
        hook('theme_script', $variables);
        if ( file_exists($variables['path']) ) return $variables['path'];
        else return FALSE;
    }

    /**
     * Returns theme of matched domain.
     *
     * @note if there is no exact matched domain, it compares with LIKE %...% condition.
     *
     * @param $domain
     * @return array|mixed|null|string
     * @see test_theme_get()
     */
    public static function getTheme($domain)
    {
        $re = hook("theme_getTheme");
        if ( $re !== null ) return $re;
        $theme = theme_config($domain);
        if ( $theme ) return $theme->get('value');
        $theme = theme_config()->query("code LIKE '%$domain%'");
        if ( $theme ) return $theme->get('value');
        else return 'default';
    }
}

