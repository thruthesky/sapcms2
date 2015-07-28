<?php
include_once "core/etc/phpunit/unittest.php";
class MessageTest extends PHPUnit_Framework_TestCase {
    public function __construct() {

    }
    public function testInput()
    {
        $re = sap\module\Message\Message::version();
        $this->assertNotEmpty($re);
    }
}
