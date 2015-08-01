<?php

use sap\core\Install;

include_once "core/etc/phpunit/test.php";
class InstallTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
    }
    public function test_install() {
        $this->assertEmpty(Install::check());
    }
}

