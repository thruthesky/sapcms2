<?php
include 'config.php';
include 'etc/defines.php';
include 'etc/helper-function.php';
include 'etc/sapcms-library.php';

spl_autoload_register( function( $class ) {
    $path = null;
    $class = str_replace('sap\\', '', $class);
    if ( strpos($class, "core") === 0 ) {
        $arr = explode('\\', $class);
        print_r($arr);
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
        echo "path:$path\n";
        $path = PATH_INSTALL . "/module/$module/src/$name.php";
    }
    include $path;
} );
