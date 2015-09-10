<?php

use sap\core\Theme\Theme;
use sap\src\Request;
use sap\src\Route;
use sap\src\Template;
include_once "core/etc/phpunit/test.php";
class ThemeTest extends PHPUnit_Framework_TestCase {
    public function test_input() {

        $_SERVER['REQUEST_URI'] = HTTP_VAR_ROUTE . "=/A/B/C&ABC=DEF";
        parse_str($_SERVER['REQUEST_URI'], $_GET);
        Request::reset();
        Route::load()->reset();
        $this->assertTrue(Template::script() == "module/A/template/B.C.html.php");

        $_SERVER['REQUEST_URI'] = "/L/M/N?a=b&c=d";
        parse_str($_SERVER['REQUEST_URI'], $_GET);
        Request::reset();
        Route::load()->reset();
        $this->assertTrue(Template::script() == "module/L/template/M.N.html.php");


        $_SERVER['REQUEST_URI'] = "/front/front/page?a=b&c=d";
        parse_str($_SERVER['REQUEST_URI'], $_GET);
        Request::reset();
        Route::load()->reset();
        $this->assertTrue(Theme::script() == "theme/default/template/front.page.html.php");

    }
    public function test_theme_get() {
        theme_config()->set('abc.org', 'abc');
        theme_config()->set('abc.def.org', 'abc_def');
        theme_config()->set('www.opqr.org', 'opqr');
        theme_config()->set('www.jaehosong.org', 'jaehosong');
        $this->assertTrue( Theme::getTheme('abc.org') == 'abc' );
        $this->assertTrue( Theme::getTheme('def') == 'abc_def' );
        $this->assertTrue( Theme::getTheme('opqr') == 'opqr' );
        $this->assertTrue( Theme::getTheme('jaeho') == 'jaehosong' );
        $this->assertTrue( Theme::getTheme('jaehosong.org') == 'jaehosong' );
        $this->assertTrue( Theme::getTheme('www.jaehosong.org') == 'jaehosong' );
        $this->assertTrue( Theme::getTheme('www.jaehosong.com') != 'jaehosong' );
        theme_config('abc.org')->delete();
        theme_config('abc.def.org')->delete();
        theme_config('www.opqr.org')->delete();
        theme_config('www.jaehosong.org')->delete();
    }
}
