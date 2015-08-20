<?php


use sap\core\system\System;


function sapcms2_error_handler($errno, $errstr, $errfile, $errline) {
    di('error handler' . PHP_EOL);
    switch ($errno) {
        case E_USER_ERROR:
            echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
            echo "  Fatal error on line $errline in file $errfile";
            echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
            echo "Aborting...<br />\n";
            exit(1);
            break;

        case E_USER_WARNING:
            echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
            break;

        case E_USER_NOTICE:
            echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
            break;

        default:
            echo "Unknown error type: [$errno] $errstr<br />\n";
            break;
    }

    exit(1);
}

if ( DEVELOPMENT_MODE ) {
    if ( System::isCommandLineInterface() ) {

    }
    else {
        /*
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
        */
        set_error_handler('sapcms2_error_handler');

    }
}


