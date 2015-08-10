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

        if ( empty($options['database']) ) die('Input database type');
        if ( empty($options['database_name']) ) die('Input database name');
        if ( empty($options['admin_id']) ) die('Input admin id');
        if ( empty($options['admin_password']) ) die('Input admin password');

        $database['database'] = $options['database'];
        $database['database_host'] = $options['database_host'];
        $database['database_name'] = $options['database_name'];
        $database['database_username'] = $options['database_username'];
        $database['database_password'] = $options['database_password'];



        Config::file(Config::getDatabasePath())
            ->data($database)
            ->saveFileConfig();

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
        if ( $error_code = File::createDir(PATH_CONFIG) ) return $error_code;
        if ( $error_code = File::createDir(PATH_UPLOAD) ) return $error_code;
        if ( $error_code = File::createDir(PATH_THUMBNAIL) ) return $error_code;
        return OK;
    }

    public static function check()
    {
        $config = System::getDatabaseConfiguration();
        if ( ! isset($config['database']) ) return FALSE;
        if ( $config['database'] == 'mysql' ) {
            if ( empty($config['database_name']) ) return FALSE;
            else return TRUE;
        }
        else if ( $config['database'] == 'sqlite' ) return TRUE;
        return FALSE;
    }

    public static function runInstall()
    {
        if ( Request::module('Install') ) {
            System::runModule();
        }
        else Response::redirect(ROUTE_INSTALL);
        return OK;
    }




    public static function enableModule($name)
    {
        if ( empty($name) ) return ERROR_MODULE_NAME_EMPTY;

        if ( config()->group('module')->value($name) ) return ERROR_MODULE_ALREADY_INSTALLED;
        $path_module = PATH_MODULE . "/$name";
        if ( ! is_dir($path_module) ) return ERROR_MODULE_NOT_EXISTS;


        // 1. include module script first
        $path = "$path_module/$name.module";
        if ( file_exists($path) ) include_once $path;

        // 2. include install script
        $path = "$path_module/$name.install";
        if ( file_exists($path) ) include $path;

        $variables = ['name'=>$name];
        hook('module_enable', $variables);

        config()->group('module')->set($name, $name);
        return OK;
    }



    /**
     * @param $name
     * @return int
     *
     * It does not check if the module directory exists or not.
     */
    public static function disableModule($name)
    {
        if ( empty($name) ) return ERROR_MODULE_NAME_EMPTY;

        if ( config()->group('module')->value($name) ) {
            config()->group('module')->getEntity($name)->delete();

            $path_module = PATH_MODULE . "/$name";


            // 1. include module script first
            $path = "$path_module/$name.module";
            if ( file_exists($path) ) include_once $path;

            // 2. include uninstall script
            $path = "$path_module/$name.uninstall";
            if ( file_exists($path) ) include_once $path;

            $variables = ['name'=>$name];
            hook('module_disable', $variables);
        }
        else return ERROR_MODULE_NOT_INSTALLED;

        return OK;
    }

}
