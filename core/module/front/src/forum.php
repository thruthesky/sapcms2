<?php
namespace sap\core\front;

use sap\src\Response;

class forum {
    public static function defaultController() {
        echo "<h1>This is forum class</h1>";
        Response::renderLayout();
    }
}
