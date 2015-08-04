<?php
use sap\src\Request;
use sap\src\Route;
use sap\src\Theme;

$_SERVER['REQUEST_URI'] = HTTP_VAR_ROUTE . "=A.B.C&ABC=DEF";
parse_str($_SERVER['REQUEST_URI'], $_GET);
$input = Request::reset();
echo Theme::script() . "\n";

$_SERVER['REQUEST_URI'] = "/L/M/N?a=b&c=d";
parse_str($_SERVER['REQUEST_URI'], $_GET);
Request::reset();
Route::load()->reset();
echo Theme::script() . "\n";



$_SERVER['REQUEST_URI'] = "/Install/form/Input?a=b&c=d";
parse_str($_SERVER['REQUEST_URI'], $_GET);
Request::reset();
Route::load()->reset();
echo Theme::script();



$_SERVER['REQUEST_URI'] = "/front/front/page?a=b&c=d";
parse_str($_SERVER['REQUEST_URI'], $_GET);
Request::reset();
Route::load()->reset();
echo Theme::script();