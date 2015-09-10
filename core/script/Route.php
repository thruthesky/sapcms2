<?php
use sap\core\Config\Config;
use sap\src\Module;
use sap\src\Request;
use sap\src\Route;

$_SERVER['REQUEST_URI'] = "/module/class/method?a=b&c=d";
$route = Route::load();
echo $route->module . "\n";
echo $route->class . "\n";
echo $route->method . "\n";


$_SERVER['REQUEST_URI'] = "/System/Install/check?a=b&c=d";
$route = Route::load()->reset();
echo $route->module . "\n";

$_SERVER['REQUEST_URI'] = HTTP_VAR_ROUTE . "=/A/B/C&a=b&c=d";
parse_str($_SERVER['REQUEST_URI'], $_GET);
Request::reset();
Request::set(HTTP_VAR_ROUTE, "/ABC/DEF/GHI");
$route = Route::load()->reset();
echo "route:\n";
echo $route->module . "\n";



Route::add('/install/check', "Install\\Install\\check");
$re = Module::run('/install/check');




echo Config::getDatabasePath() . "\n";



$route = "/config/path/database";
Route::add($route, "Config\\Config\\getDatabasePath");
$path = Module::run($route);
print_r($path);






