<?php


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


// T I M E Z O N E
// https://docs.google.com/document/d/1w92umk-qjkvge1W5nWkYcX2yAm2ZwDdJTD9XsIQBp70/edit#heading=h.kyl1c0jki1ek
if ( $timezone = session_get(USER_TIMEZONE_1) ) {
    date_default_timezone_set($timezone);
}
else if ( $timezone = session_get(USER_TIMEZONE_2) ) {
    date_default_timezone_set($timezone);
}
else  if ( $timezone = config(USER_TIMEZONE_3) ) {
    date_default_timezone_set($timezone);
}
