<?php


use sap\src\Route;
use sap\src\Template;

class TemplateTest extends PHPUnit_Framework_TestCase {
    public function test_template() {
        Route::set("/abc/def/ghi");
        $this->assertTrue(Template::script() == "module/abc/template/def.ghi.html.php");


        Route::set("/A/B/C?ABC=DEF");
        $this->assertTrue(Template::script() == "module/A/template/B.C.html.php");


        Route::set("/def?ABC=DEF");
        $path = Template::script();
        $this->assertTrue($path == "module/def/template/def.page.html.php");




    }
}

