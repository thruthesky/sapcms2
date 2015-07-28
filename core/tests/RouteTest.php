<?php
include_once "core/etc/phpunit/unittest.php";
use \sap\core\Request;
use \sap\core\Route;
class RouteTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        Request::set(HTTP_VAR_ROUTE, "Install.Form.Input");
    }
    public function testInstall()
    {
        $this->assertNotEmpty(Request::getRoute());
    }
}

