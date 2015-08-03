<?php
namespace sap\core\Install;

use sap\core\Config\Config;
use sap\src\File;
use sap\src\Response;

class Install {
    /**
     *
     */
    public static function page() {
        dog(__METHOD__);
        Response::renderSystemLayout(['template'=>'fornt.page']);
    }


    /**
     * @return bool
     *
     *  - return true if the system is installed.
     *  - otherwise, returns false.
     */
    public static function check()
    {
        return file_exists(Config::getDatabasePath()) ? OK : ERROR;
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
