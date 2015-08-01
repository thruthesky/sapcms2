<?php
use sap\core\Install\Form;
use sap\src\Request;

include_once "core/etc/phpunit/test.php";
class FormTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
    }
    public function test_input()
    {
        Request::set(HTTP_VAR_ROUTE, "Install.Form.Input");
        ob_start();
        Form::Input();
        $out = ob_get_clean();
        $this->assertNotEmpty($out);
    }
}

