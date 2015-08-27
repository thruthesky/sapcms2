<?php
$time_start_script = microtime(true);
define('PATH_INSTALL', '.');
include PATH_INSTALL.'/core/config.php';
include PATH_INSTALL.'/core/etc/defines.php';
include PATH_INSTALL.'/core/etc/helper-function.php';
include PATH_INSTALL.'/core/etc/sapcms-library.php';
require PATH_INSTALL.'/core/composer/vendor/autoload.php';
spl_autoload_register( function( $class ) {
    $path = null;
    if ( strpos($class, 'sap') !== false ) {
        $class = str_replace('sap\\', '', $class);
        if ( strpos($class, "core") === 0 ) {
            $arr = explode('\\', $class);
            $module = $arr[1];
            $name = $arr[2];
            $path = PATH_INSTALL . "/core/module/$module/src/$name.php";
        }
        else if ( strpos($class, "src") === 0 ) {
            $arr = explode('\\', $class);
            $path = PATH_INSTALL . "/core/src/$arr[1].php";
        }
        else {
            $arr = explode('\\', $class);
            if ( count($arr) == 1 ) {
                $module = $arr[0];
                $name = $arr[0];
            }
            else {
                $module = $arr[0];
                $name = $arr[1];
            }
            $path = PATH_INSTALL . "/module/$module/src/$name.php";
        }
	include $path;
    }
    else if (strpos($class, 'PHPImageWorkshop') !== false ) {

        $path = PATH_INSTALL . "/core/external-library/$class.php";
	include $path;
    }
} );
include PATH_INSTALL . '/core/bootstrap.php';
