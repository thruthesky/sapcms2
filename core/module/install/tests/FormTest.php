<?php
include_once "core/etc/phpunit/unittest.php";
class FormTest extends PHPUnit_Framework_TestCase {
    public function __construct() {

    }
    public function testInput()
    {
        sap\core\Request::set(HTTP_VAR_ROUTE, "Install.Form.Input");
        ob_start();
        sap\core\module\Install\Form::Input();
        $out = ob_get_clean();
        $this->assertNotEmpty($out);
    }
}
