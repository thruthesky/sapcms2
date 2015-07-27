<?php
include_once "core/etc/phpunit/unittest.php";
class SystemTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
    }
    public function testInput()
    {
        Request::set(HTTP_VAR_ROUTE, "Install.Form.Input");
        $this->assertNotEmpty(System::version());
    }
}
