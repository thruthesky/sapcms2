<?php
namespace sap\core\admin;

use sap\core\Install\Install;
use sap\src\Request;
use sap\src\Response;

class module {
    public static function all() {
        Response::renderSystemLayout();
    }
    public static function enabled() {
        Response::renderSystemLayout();
    }

    public static function enable() {

        $code = Install::enableModule(Request::get('name'));

        if ( $code ) {
            // error
        }

        Response::renderSystemLayout(['template'=>'module.all']);
    }

    public static function disable() {


        $code = Install::disableModule(Request::get('name'));

        if ( $code ) {
            // error
        }


        Response::renderSystemLayout(['template'=>'module.enabled']);
    }

}
