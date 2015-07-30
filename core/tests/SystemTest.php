<?php
include_once "core/etc/phpunit/test.php";
use \sap\core\System;
class SystemTest extends PHPUnit_Framework_TestCase {
    public function __construct() {

    }

    public function testDefaults() {
        $this->assertNotEmpty(System::version());
        $this->assertTrue(System::isCommandLineInterface());

    }

    public function test_Install()
    {

        

    }
}
