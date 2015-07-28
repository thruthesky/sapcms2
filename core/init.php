<?php
namespace sap;
use sap\core\Request;
use sap\core\Response;
use sap\core\Route;
use sap\core\System;

include 'config.php';
include 'etc/defines.php';
include 'etc/sapcms-library.php';

spl_autoload_register( function( $class ) {
    $class = str_replace('sap', '', $class);
    if ( strpos($class, 'module') ) {
        $pi = pathinfo($class);
        $class = $pi['dirname'] . '/src/' . $pi['filename'];
    }
    else if ( strpos($class, 'core') !== false ) $class = str_replace("core", "core/src", $class);
    $path = PATH_INSTALL . "$class.php";
    include $path;
} );


$system = core\System::load();


if ( System::isCommandLineInterface() ) {
    core\CommandLineInterface::Run();
}
else {
    if ( ! $system->isInstalled() ) {
        if ( Request::isPageInstall() ) System::runModule();
        else Response::redirect(Route::create("Install.Form.Input"));
    }
}
