<?php
define('HTTP_VAR_ROUTE', 'route');
define('DEFAULT_MODULE','front');
define('DEFAULT_CLASS','default');
define('DEFAULT_CONTROLLER','defaultController');



$theme = 'default';

define('PATH_INSTALL', getcwd());
define('PATH_DATA', PATH_INSTALL . '/data');
define('PATH_LOG', PATH_INSTALL . '/debug.log');

define('PATH_SQLITE_DATABASE', PATH_DATA . '/sapcms.sqlite');


define('PATH_CONFIG', PATH_DATA . '/config');
define('PATH_CONFIG_DATABASE', PATH_CONFIG . '/database.php');




define('PATH_UPLOAD', PATH_DATA . '/upload');
define('PATH_THUMBNAIL', PATH_DATA . '/thumbnail');
