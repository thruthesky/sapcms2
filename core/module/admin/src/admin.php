<?php
namespace sap\core\admin;

use sap\src\Response;

class admin {
    public static function page() {
        Response::renderSystemLayout(['template'=>'index']);
    }

    public static function database_information() {
        Response::renderSystemLayout(['template'=>'database-information']);
    }

}
