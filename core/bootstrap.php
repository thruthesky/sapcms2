<?php


use sap\core\system\System;

if ( DEVELOPMENT_MODE ) {
    if ( System::isCommandLineInterface() ) {

    }
    else {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }
}
