<?php
define('OK', 0);
define('ERROR', -1);
define('ERROR_SYSTEM_NOT_INSTALLED', -401);
$error_message[ERROR_SYSTEM_NOT_INSTALLED] = 'System is not installed.';

define('ROUTE_INSTALL', "Install");
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



