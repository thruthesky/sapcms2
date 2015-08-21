<?php
namespace sap\core\admin;

use sap\core\Config\Config;
use sap\src\Request;
use sap\src\Response;

class setting {
    public static function url() {
        if ( Request::submit() ) {
            config()->set(URL_SITE, Request::get(URL_SITE));
        }
        Response::renderSystemLayout(['template'=>'admin.url']);
    }
    public static function timezone() {
        if ( submit() ) {
            config()->set(USER_TIMEZONE_3, request(USER_TIMEZONE_3));
        }
        Response::renderSystemLayout(['template'=>'admin.timezone']);
    }
}