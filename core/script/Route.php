<?php
use sap\src\Route;

$_SERVER['REQUEST_URI'] = "/module/class/method?a=b&c=d";
$route = Route::load();
echo $route->module . "\n";
echo $route->class . "\n";
echo $route->method . "\n";


$_SERVER['REQUEST_URI'] = "/System/Install/check?a=b&c=d";
$route = Route::load()->reset();
echo $route->module . "\n";