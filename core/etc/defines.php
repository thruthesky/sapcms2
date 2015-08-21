<?php
define('OK', 0);
define('ERROR', -1);
$error_message = [];
define('ERROR_SYSTEM_NOT_INSTALLED', -401);
$error_message[ERROR_SYSTEM_NOT_INSTALLED] = 'System is not installed.';
define('ERROR_NO_DATABASE_CONFIG_FILE', -402);
$error_message[ERROR_NO_DATABASE_CONFIG_FILE] = 'Database configuration file is not correct. The system may not be installed, yet.';


define('ROUTE_INSTALL', "/install");
define('ROUTE_ROOT', '/');
define('USER_TIMEZONE_1', 'utz1');
define('USER_TIMEZONE_2', 'utz2');
define('USER_TIMEZONE_3', 'utz3');
/**
 * UNDEFINED is constant that can be used on behalf of null comparison.
 * Use UNDEFINED when the value of parameter could be FALSE, empty, null, etc.
 *
 */
define('UNDEFINED', 'U.cbav~@^^/0');



define('ERROR_INSTALL', -1234);
define('ERROR_FAIL_TO_SAVE', -400101);
define('ERROR_FAIL_TO_READ', -400102);
define('ERROR_MODULE_NAME_EMPTY', -400501);
$error_message[ERROR_MODULE_NAME_EMPTY] = 'Module name is empty. Input module name.';
define('ERROR_MODULE_NOT_EXISTS', -400502);
$error_message[ERROR_MODULE_NOT_EXISTS] = 'Module does not exists.';
define('ERROR_MODULE_ALREADY_INSTALLED', -400503);
$error_message[ERROR_MODULE_ALREADY_INSTALLED] = 'Module is already enabled.';

define('ERROR_MODULE_NOT_INSTALLED', -400504);
$error_message[ERROR_MODULE_NOT_INSTALLED] = 'Module is not enabled.';

define('ERROR_USER_NOT_FOUND_BY_THAT_ID', -5011);
$error_message[ERROR_USER_NOT_FOUND_BY_THAT_ID] = 'User is not found by that ID - #id';

define('ERROR_WRONG_PASSWORD', -5012);
$error_message[ERROR_WRONG_PASSWORD] = 'Wrong password.';


define('ERROR_ID_TOO_LONG', -5013);
$error_message[ERROR_ID_TOO_LONG] = 'The length of User ID is too long.';

define('ERROR_ID_IS_EMPTY', -5014);
$error_message[ERROR_ID_IS_EMPTY] = 'ID is empty.';
define('ERROR_PASSWORD_IS_EMPTY', -5015);
$error_message[ERROR_PASSWORD_IS_EMPTY] = 'Password is empty.';

define('ERROR_NO_MODULE_INIT_SCRIPT', -5016);
$error_message[ERROR_NO_MODULE_INIT_SCRIPT] = 'Module init script does not exists.';

