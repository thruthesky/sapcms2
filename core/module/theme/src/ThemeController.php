<?php
namespace sap\core\Theme;
use sap\src\Response;


/**
 *
 *
 *
 */
class ThemeController {
    public static function config() {
        return Response::renderSystemLayout(['template'=>'theme.config']);
    }
    public static function configSubmit() {

        $domain = request('domain');
        $entity = theme_config($domain);
        if ( $entity ) {
            error(-50610, "Domain exists.");
            return Response::renderSystemLayout(['template'=>'theme.config']);
        }
        else {
            $theme = request('theme');
            theme_config()->set($domain, $theme);
            return Response::redirect('/admin/theme/config');
        }
    }
    public static function configDelete($idx) {
        theme_config($idx)->delete();
        return Response::redirect('/admin/theme/config');
    }
}
