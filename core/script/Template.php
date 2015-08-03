<?php
use sap\src\Request;
use sap\src\Route;
use sap\src\Template;

Route::set("/abc/def/ghi?no=1234&name=JaeHo");
echo Template::script();


$_SERVER['REQUEST_URI'] = "/Install/form/Input?a=b&c=d";
parse_str($_SERVER['REQUEST_URI'], $_GET);
Request::reset();
Route::load()->reset();
echo Template::script();