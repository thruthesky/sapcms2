<?php
namespace sap;
use sap\core\module\Install\Install;
use sap\core\Request;
use sap\core\Response;
use sap\core\Route;
use sap\core\System;


include 'config.php';
include 'etc/defines.php';
include 'etc/helper-function.php';
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


dog("init begins");
$system = core\System::load();
dog("System object loaded.");
/**
 * Return after loading System and its core libraries,
 *  if it is running on CLI without checking Installation and running further.
 */
if ( System::isCommandLineInterface() ) return core\CommandLineInterface::Run();


if ( Install::check() ) {
    if ( Request::isPageInstall() ) System::runModule();
    else Response::redirect(Route::create(ROUTE_INSTALL));
}
