<?php
use sap\src\Request;
use sap\src\Route;

include_once "core/etc/phpunit/test.php";


class RouteTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
    }

    public function test_module_class_method()
    {

        $_SERVER['REQUEST_URI'] = "/module/class/method";
        $route = Route::load();
        $this->assertTrue($route->module == 'module');
        $this->assertTrue($route->class == 'class');
        $this->assertTrue($route->method == 'method');


        $_SERVER['REQUEST_URI'] = "/System_TEST/Install_TEST_CLASS/check?a=b&c=d";
        $route = Route::load()->reset();
        $this->assertTrue($route->module == 'System_TEST');
        $this->assertTrue($route->class == 'Install_TEST_CLASS');
        $this->assertTrue($route->method == 'check');

        Request::set(HTTP_VAR_ROUTE, "Install.Form.Input");
        $route = Route::load()->reset();
        $this->assertTrue($route->module == 'Install');

    }


}

