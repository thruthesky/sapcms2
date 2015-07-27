<?php
include_once "core/etc/phpunit/unittest.php";
class FormTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        include System::loadModuleClass('Install', 'Form');
    }
    public function testInput()
    {
        Request::set(HTTP_VAR_ROUTE, "Install.Form.Input");
        ob_start();
        Form::Input();
        $out = ob_get_clean();
        $this->assertNotEmpty($out);
    }
}