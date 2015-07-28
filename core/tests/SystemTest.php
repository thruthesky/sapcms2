<?php
include_once "core/etc/phpunit/unittest.php";
use \sap\core\System;
class SystemTest extends PHPUnit_Framework_TestCase {
    public function __construct() {

    }

    public function testDefaults() {
        $this->assertNotEmpty(System::version());
        $this->assertTrue(System::isCommandLineInterface());

    }

    public function testInstall()
    {

        if ( System::get()->isInstalled() ) {

        }
        else {
            System::install();
        }
        $this->assertTrue(System::get()->isInstalled());

    }
}
