<?php
namespace sap\core\admin;

use sap\core\Config\Config;
use sap\src\Request;
use sap\src\Response;

class setting {
    public static function url() {

        if ( Request::submit() ) {
            Config::load()->set(URL_SITE, Request::get(URL_SITE));
        }
        Response::renderSystemLayout(['template'=>'url']);
    }
}