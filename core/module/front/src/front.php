<?php
namespace sap\core\module\front;
use sap\core\Response;

class front {
    public static function defaultController() {
        Response::renderLayout();
    }
}
