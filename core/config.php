<?php
define('HTTP_VAR_ROUTE', 'route');
define('DEFAULT_MODULE','front');
define('DEFAULT_CONTROLLER','page');

define('DEVELOPMENT_MODE', true);
$theme = 'default';


define('PATH_DATA', PATH_INSTALL. '/data');
define('PATH_DEBUG_LOG', PATH_DATA . '/debug.log');
define('PATH_ERROR_LOG', PATH_DATA . '/error.log');


define('PATH_SQLITE_DATABASE', PATH_DATA . '/sapcms.sqlite');


define('PATH_CONFIG', PATH_DATA . '/config');
define('PATH_CONFIG_DATABASE', PATH_CONFIG . '/database.php');

define('PATH_MODULE', PATH_INSTALL . '/module');


define('PATH_UPLOAD', PATH_DATA . '/upload');
define('PATH_THUMBNAIL', PATH_DATA . '/thumbnail');

define('URL_SITE', 'url_site');


define('NO_ITEM', 'no_item_per_page');
define('DEFAULT_NO_ITEM', 10);
define('NO_PAGE', 'no_page_per_nav');
define('DEFAULT_NO_PAGE', 7);

define('DEFAULT_TIMEZONE', "UTC");


date_default_timezone_set(DEFAULT_TIMEZONE);
