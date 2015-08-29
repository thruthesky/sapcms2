<?php
use sap\core\Config\Config;
use sap\core\System\System;
use sap\src\Module;
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

        Request::set(HTTP_VAR_ROUTE, "/Install/Form/Input");
        $route = Route::load()->reset();
        $this->assertTrue($route->module == 'Install');

        Request::set(HTTP_VAR_ROUTE, "/G/H/I");
        $route = Route::load()->reset();
        $this->assertTrue($route->module == 'G');
        $this->assertTrue($route->class == 'H');
        $this->assertTrue($route->method == 'I');
    }

    public function test_routing() {
        Route::add('/install/check', "install\\install\\check");
        $this->assertTrue( Route::run('/install/check') == true );

        $route = "/config/path/database";
        Route::add($route, "config\\config\\getDatabasePath");
        $this->assertTrue( Config::getDatabasePath() == Route::run($route) );
        $this->assertTrue( Config::getDatabasePath() == Module::run($route) );
        $this->assertTrue( Config::getDatabasePath() == System::runModule($route) );
    }

    public function test_routing_variable() {
        route('/a/b/c', 'a\\b\\c');
        $this->assertTrue(route()->match('/a/b/c') == 'a\\b\\c');

        route('/d/e/*', 'd\\e\\ALL');
        $this->assertTrue(route()->match('/d/e/f') == 'd\\e\\ALL');
        $this->assertTrue(route()->match('/d/e/') == 'd\\e\\ALL');
        $this->assertTrue(route()->match('/d/e/ALL') == 'd\\e\\ALL');

        route('/a/*', 'a\\b\\ALL');
        $this->assertTrue(route()->match('/a/abc') == 'a\\b\\ALL');
        $this->assertTrue(route()->getMatchVar() == 'abc');

    }

}

