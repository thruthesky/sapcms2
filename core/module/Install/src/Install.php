<?php
namespace sap\core;

use sap\src\Config;
use sap\src\Database;
use sap\src\File;

class Install {

    /**
     * @return bool
     *
     *  - return true if the system is installed.
     *  - otherwise, returns false.
     */
    public static function check()
    {
        if ( file_exists(Config::getDatabasePath()) ) return OK;
        else return ERROR;
    }

    /**
     * Creates data directories for the system.
     * @note It is called on Config::create()
     * @return int
     */
    public static function createDirs()
    {
        dog(__METHOD__);
        if ( $error_code = File::createDir(PATH_CONFIG) ) return $error_code;
        if ( $error_code = File::createDir(PATH_UPLOAD) ) return $error_code;
        if ( $error_code = File::createDir(PATH_THUMBNAIL) ) return $error_code;
        return OK;
    }






}
