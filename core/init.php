<?php
use sap\core\Install;
use sap\core\System;
use sap\src\CommandLineInterface;
use sap\src\Config;
use sap\src\Request;
use sap\src\Response;
use sap\src\Route;

include 'config.php';

include 'etc/defines.php';

include 'etc/helper-function.php';

include 'etc/sapcms-library.php';





dog("init begins");
$system = System::load();
dog("System object loaded.");



/**
 * Loading modules initialization files.
 *
 *
 *
 */
foreach ( $core_modules as $module ) {
    $path = "core/module/$module/$module.module";
    if ( file_exists($path) ) include $path;
}





/**
 * Return after loading System and its core libraries,
 *  if it is running on CLI without checking Installation and running further.
 */
if ( System::isCommandLineInterface() ) return CommandLineInterface::Run();

if ( Install::check() ) {
    if ( Request::isPageInstall() ) System::runModule();
    else Response::redirect(Route::create(ROUTE_INSTALL));
    return;
}


$install = Config::load()->group('install');
if ( $install ) {
    foreach( $install as $module ) {
        $path = "module/$module[value]/$module[value].module";
        include $path;
    }
}

System::runModule();

