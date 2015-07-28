<?php
include_once "core/etc/phpunit/unittest.php";
use sap\core\Database;
use \sap\core\System;
class DatabaseTest extends PHPUnit_Framework_TestCase {
    public function __construct() {

    }

    public function testDefaults() {
        $db = Database::sqlite(PATH_SQLITE_DATABASE);
    }


}
