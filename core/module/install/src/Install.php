<?php
namespace sap\core\Install;

use sap\core\Config\Config;
use sap\core\System\System;
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
        if ( Request::submit() ) self::submit();
        else {
            Response::renderSystemLayout(['template'=>'install.form']);
        }
    }

    public static function submit($options=[]) {

        if ( empty($options) ) {
            $options = Request::get();
        }
        else {
            $options['admin_id'] = $options['admin-id'];
            $options['admin_password'] = $options['admin-password'];
        }

        $options[URL_SITE] = get_current_url();

        $options[URL_SITE] = str_replace('install', '', $options[URL_SITE] );


        Install::initializeSystem($options);
        Response::renderSystemLayout(['template'=>'install.success']);

    }

    public static function initializeSystem($options)
    {

        if ( empty($options['database']) ) die('Input admin database');
        if ( empty($options['admin_id']) ) die('Input admin id');
        if ( empty($options['admin_password']) ) die('Input admin password');

        Config::file(Config::getDatabasePath())
            ->data($options)
            ->save();

        System::reloadDatabaseConfiguration();

        try {
            $db = Database::load();
        }
        catch ( \Exception $e ) {
            File::delete(Config::getDatabasePath());
            return;
        }


        config()->createTable();

        config()
            ->set('admin_id', $options['admin_id'])
            ->set(URL_SITE, $options[URL_SITE]);

        user()->createTable();
        user()->create($options['admin_id'])
            ->setPassword($options['admin_password'])
            ->save();
    }


    /**
     * @return bool
     *
     *  - return true if the system is installed.
     *  - otherwise, returns false.
     */
    /*
    public static function check()
    {
        return file_exists(Config::getDatabasePath()) ? OK : ERROR;
    }
    */

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

    public static function check()
    {
        $config = System::getDatabaseConfiguration();
        return isset($config['database']);
    }

    public static function runInstall()
    {
        dog("System is going to install now.");
        if ( Request::module('Install') ) {
            System::runModule();
        }
        else Response::redirect(ROUTE_INSTALL);
        return OK;
    }


}
