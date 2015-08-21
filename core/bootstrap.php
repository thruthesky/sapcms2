<?php


use sap\core\system\System;



if ( DEVELOPMENT_MODE ) {
    if ( System::isCommandLineInterface() ) {

    }
    else {
        ErrorHandler()->Run();
    }
}
else {
    ini_set('display_errors', 0);
}


