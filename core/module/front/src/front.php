<?php
namespace sap\core\front;


use sap\src\Response;

class front {
    public static function defaultController() {
        Response::renderLayout();
    }
}
