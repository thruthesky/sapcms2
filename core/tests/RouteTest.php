<?php
use sap\src\Request;

include_once "core/etc/phpunit/test.php";


class RouteTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
        Request::set(HTTP_VAR_ROUTE, "Install.Form.Input");
    }
    public function testInstall()
    {
        $this->assertNotEmpty(Request::getRoute());
    }
}

