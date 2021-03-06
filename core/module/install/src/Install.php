<?php
namespace sap\core\Install;

use sap\core\config\Config;
use sap\core\system\System;
use sap\core\user\User;
use sap\src\Database;
use sap\src\File;
use sap\src\Module;
use sap\src\Request;
use sap\src\Response;

class Install {

    private static $done_install_check = false;
    private static $check = false;
    private static $installOptions = [];

    /**
     *
     */
    public static function page() {
        if ( Request::submit() ) {
            self::submit();
            Response::renderTemplate(['template'=>'install.success']);
        }
        else {
            Response::renderTemplate(['template'=>'install.form']);
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

        $options[URL_SITE] = ''; // get_current_url();

        // $options[URL_SITE] = str_replace('install', '', $options[URL_SITE] );

        Install::initializeSystem($options);
    }

    public static function initializeSystem($options)
    {
        self::setInstallOptions($options);



        if ( empty($options['database']) ) die('Input database type');
        if ( $options['database'] == 'sqlite' ) {

        }
        else {
            if ( empty($options['database_name']) ) die('Input database name');
        }
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

        /**
        config()->createTable();
        config()
            ->set('admin', $options['admin_id'])
            ->set(URL_SITE, $options[URL_SITE]);

        user()->createTable();
        user()->create($options['admin_id'])
            ->setPassword($options['admin_password'])
            ->save();
        */

        /**
         * RUN core module install
         */
        System::run_core_module_install();
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
        if ( $error_code = File::createDir(PATH_CACHE) ) return $error_code;
        return OK;
    }


    /**
     *
     * return TRUE if installed.
     *
     * @return bool
     */
    public static function check()
    {
        if (  self::$done_install_check ) return self::$check;

        $config = System::loadDatabaseConfiguration();
        if ( ! isset($config['database']) ) self::$check = false;
        if ( $config['database'] == 'mysql' ) {
            if ( empty($config['database_name']) ) self::$check = false;
            else self::$check = TRUE;
        }
        else if ( $config['database'] == 'sqlite' ) self::$check = TRUE;

        return self::$check;
    }

    public static function runInstall()
    {
        if ( Request::isModule('install') ) {
            //System::runModule();
            Module::run();
        }
        else Response::redirect(ROUTE_INSTALL);
        return OK;
    }


    /**
     *
     * Enable 'core module' or 'user module'
     *
     * @Attention - It saves 'module name' on config meta table ONLY IF it enables 'user module'.
     *
     * @param $name
     * @return int|mixed
     */
    public static function enableModule($name)
    {
        if ( empty($name) ) return ERROR_MODULE_NAME_EMPTY;

        if ( config()->group('module')->value($name) ) return ERROR_MODULE_ALREADY_INSTALLED;

        if ( is_core_module($name) ) $path_module = PATH_CORE_MODULE . "/$name";
        else $path_module = PATH_MODULE . "/$name";

        if ( ! is_dir($path_module) ) return ERROR_MODULE_NOT_EXISTS;

        // 1. include module script first
        $path = "$path_module/$name.module";
        //echo "module init: $path\n";
        if ( file_exists($path) ) {
            include_once $path;
        }
        else {
            echo get_error_message(ERROR_NO_MODULE_INIT_SCRIPT);
            return ERROR_NO_MODULE_INIT_SCRIPT;
        }

        // 2. include install script
        $path = "$path_module/$name.install";
        //echo "install path: $path\n";
        if ( file_exists($path) ) {
            //echo "include $path\n";
            $re = include $path;
            if ( $re < 0 ) {
                //echo "ERROR: ";
                return $re;
            }
            else {
                //echo "NO ERROR: ";
            }
        }
        else {
            //echo "Install file does not exists\n";
        }

        $variables = ['name'=>$name];
        hook('module_enable', $variables);


        if ( ! is_core_module($name) ) {
            config()->group('module')->set($name, $name);
        }

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

            $path_module = PATH_MODULE . "/$name";


            // 1. include module script first
            $path = "$path_module/$name.module";
            if ( file_exists($path) ) include_once $path;

            // 2. include uninstall script
            $path = "$path_module/$name.uninstall";
            if ( file_exists($path) ) {
                $code = include_once $path;
                if ( $code < 0 ) {
                    return $code;
                }

            }

            config()->group('module')->getEntity($name)->delete();
            $variables = ['name'=>$name];
            hook('module_disable', $variables);
        }
        else return ERROR_MODULE_NOT_INSTALLED;

        return OK;
    }

    private static function setInstallOptions($options)
    {
        self::$installOptions = $options;
    }
    public static function getInstallOptions()
    {
        return self::$installOptions;
    }

}
