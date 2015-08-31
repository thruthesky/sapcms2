<?php
/**
 * @Attention This script runs only after :
 *      - (1) system is installed,
 *      - (2) core modules are loaded,
 *      - (3) Database is ready to use.
 */




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
