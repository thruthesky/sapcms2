<?php

use sap\src\Request;
use sap\src\Route;
use sap\src\Theme;

class ThemeTest extends PHPUnit_Framework_TestCase {
    public function test_input() {

        $_SERVER['REQUEST_URI'] = HTTP_VAR_ROUTE . "=A.B.C&ABC=DEF";
        parse_str($_SERVER['REQUEST_URI'], $_GET);
        Request::reset();
        Route::load()->reset();
        $this->assertTrue(Theme::script() == "module/A/template/B.C.html.php");

        $_SERVER['REQUEST_URI'] = "/L/M/N?a=b&c=d";
        parse_str($_SERVER['REQUEST_URI'], $_GET);
        Request::reset();
        Route::load()->reset();
        $this->assertTrue(Theme::script() == "module/L/template/M.N.html.php");

        $_SERVER['REQUEST_URI'] = "/Install/form/Input?a=b&c=d";
        parse_str($_SERVER['REQUEST_URI'], $_GET);
        Request::reset();
        Route::load()->reset();
        $this->assertTrue(Theme::script() == "core/module/Install/template/form.Input.html.php");

    }
}
