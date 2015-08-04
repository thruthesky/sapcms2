<?php
namespace sap\core\Install;

use sap\core\Config\Config;
use sap\core\User\User;
use sap\src\Database;
use sap\src\File;
use sap\src\Request;
use sap\src\Response;

class Install {
    /**
     *
     */
    public static function page() {
        dog(__METHOD__);
        Response::renderSystemLayout(['template'=>'install.form']);
    }

    public static function submit($options=[]) {

        if ( empty($options) ) {
            $options = Request::get();
        }
        else {
            $options['admin_id'] = $options['admin-id'];
            $options['admin_password'] = $options['admin-password'];
        }
        Install::initializeSystem($options);
        Response::renderSystemLayout(['template'=>'install.success']);

    }

    public static function initializeSystem($options)
    {


        Config::file(Config::getDatabasePath())
            ->data($options)
            ->save();

        try {
            $db = Database::load();
        }
        catch ( \Exception $e ) {
            File::delete(Config::getDatabasePath());
            return;
        }



        Config::initStorage();
        User::initStorage();

        User::create()
            ->set('id',$options['admin_id'])
            ->set('password', $options['admin_password'])
            ->save();

        Config::load()
            ->set('admin_id', $options['admin_id']);
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