<?php
/**
 * @Attention This script runs before system install check.
 *
 *      - This script runs even if the system is not installed.
 *          so, do not use any code that depends on installation.
 */

use sap\core\system\System;

/**
 * @Attention This must be here.
 *      - Database class uses System object, so System object must be loaded as soon as the script begins.
 */
System::load();


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

