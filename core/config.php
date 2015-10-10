<?php
define('HTTP_VAR_ROUTE', 'route');
define('DEFAULT_MODULE','front');
define('DEFAULT_CONTROLLER','page');

// Development option
define('DEVELOPMENT_MODE', true);






define('PATH_DATA', PATH_INSTALL. '/data');
define('URL_PATH_DATA', 'data');
define('PATH_CACHE', PATH_DATA. '/cache');
define('URL_PATH_CACHE', URL_PATH_DATA . '/cache');
define('PATH_UPLOAD', PATH_DATA . '/upload');
define('URL_PATH_UPLOAD', URL_PATH_DATA . '/upload');

define('PATH_DEBUG_LOG', PATH_DATA . '/debug.log');
define('PATH_ERROR_LOG', PATH_DATA . '/error.log');


define('PATH_SQLITE_DATABASE', PATH_DATA . '/sapcms.sqlite');


define('PATH_CONFIG', PATH_DATA . '/config');
define('PATH_CONFIG_DATABASE', PATH_CONFIG . '/database.php');

define('PATH_CORE_MODULE', PATH_INSTALL . '/core/module');
define('PATH_MODULE', PATH_INSTALL . '/module');



define('URL_SITE', 'url_site');


define('NO_ITEM', 'no_item_per_page');
define('DEFAULT_NO_ITEM', 10);
define('NO_PAGE', 'no_page_per_nav');
define('DEFAULT_NO_PAGE', 7);

define('DEFAULT_TIMEZONE', "UTC");


date_default_timezone_set(DEFAULT_TIMEZONE);
