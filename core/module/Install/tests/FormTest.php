<?php
include_once "core/etc/phpunit/test.php";
class FormTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
    }
    public function test_input()
    {
        sap\core\Request::set(HTTP_VAR_ROUTE, "Install.Form.Input");
        ob_start();
        sap\core\module\Install\Form::Input();
        $out = ob_get_clean();
        $this->assertNotEmpty($out);
    }
}

