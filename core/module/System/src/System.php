<?php
namespace sap\core\System;
use sap\core\Config\Config;
use sap\core\Install\Install;
use sap\core\User\User;
use sap\src\CommandLineInterface;
use sap\src\Database;
use sap\src\File;
use sap\src\Module;
use sap\src\Request;
use sap\src\Response;
use sap\src\Route;

class System {
    static $system = null;
    static $version = '2.0.1';
    private static $count_log = 0;
    private static $config_database = null;
    private $path = null;
    private $filename =null;
    public $script = null;
    private $render = [];



    public static function admin_page() {
        Response::renderSystemLayout(['template'=>'admin.page']);
    }




    /**
     *
     * It creates and returns the System object.
     * @note there is only one System object in the entire script.
     *
     * @return null|System
     */
    public static function load() {
        if ( empty(self::$system) ) self::$system = new System();


        return self::$system;
    }

    /**
     *
     * Returns the instance of the System object.
     *
     * @return null|System
     *
     */
    public static function get() {
        return self::load();
    }



    public static function version()
    {
        return self::$version;
    }

    public static function runModule($route=null)
    {
        return Module::run($route);
    }

    public static function loadModuleClass($module, $class) {
        return System::get()
            ->module($module, $class)
            ->script();
    }

    public static function isCoreModule($module=null)
    {
        return is_core_module($module);
    }

    public static function install($options)
    {
        dog(__METHOD__);

        Install::submit($options);
    }





    public static function isCommandLineInterface()
    {
        if ( isset($GLOBALS['argv']) ) {
            if ( $GLOBALS['argv']['0'] == 'index.php' ) return true;
        }

        if ( defined('CommandLineInterfaceMode') ) {
            return true;
        }
        return false;
    }



    public static function module_install_code($name) {
        return "install.$name";
    }
    public static function enable($name)
    {
        if ( empty($name) ) return ERROR_MODULE_NAME_EMPTY;
        $code = self::module_install_code($name);
        if ( Config::load()->get($code) ) return ERROR_MODULE_ALREADY_INSTALLED;
        $path_module = PATH_MODULE . "/$name";
        if ( ! is_dir($path_module) ) return ERROR_MODULE_NOT_EXISTS;


        include "$path_module/$name.module";

        $variables = ['name'=>$name];
        call_hooks('module_enable', $variables);


        Config::load()->set($code, $name);

        return OK;
    }

    /**
     * @param $name
     * @return int
     *
     * It does not check if the module directory exists or not.
     */
    public static function disable($name)
    {
        if ( empty($name) ) return ERROR_MODULE_NAME_EMPTY;
        $code = self::module_install_code($name);
        if ( Config::load()->get($code) ) {
            Config::load()->delete($code);

            $variables = ['name'=>$name];
            call_hooks('module_disable', $variables);
        }
        else return ERROR_MODULE_NOT_INSTALLED;

        return OK;
    }

    /**
     * @return int
     */
    public static function run()
    {
        self::load();
        self::loadDatabaseConfiguration();
        self::load_core_module_files();
        /**
         * Return after loading System and its core libraries,
         *  if it is running on CLI without checking Installation and running further.
         */
        if ( System::isCommandLineInterface() ) return CommandLineInterface::Run();
        if ( ! Install::check() ) return Install::runInstall();
        self::load_module_files();
        System::runModule();
        return OK;
    }

    private static function load_core_module_files()
    {
        /**
         * Loading modules initialization files.
         *
         *
         *
         */
        foreach ( self::getCoreModules() as $module ) {
            $path = "core/module/$module/$module.module";
            if ( file_exists($path) ) include $path;
        }
    }

    public static function getCoreModules()
    {
        return Module::getCoreModules();
    }

    public static function setRender($render)
    {
        System::get()->render = $render;
    }
    public static function getRender()
    {
        return System::get()->render;
    }

    /**
     *
     * It only loads database configuration once and for all.
     *
     * @return bool|null
     */
    public static function loadDatabaseConfiguration()
    {
        if ( self::$config_database === null ) {
            self::$config_database = Config::read(PATH_CONFIG_DATABASE);
        }
        return self::getDatabaseConfiguration();
    }

    /**
     *
     * It reloads the database configuration
     * @return bool|null
     */
    public static function reloadDatabaseConfiguration()
    {
        self::$config_database = Config::read(PATH_CONFIG_DATABASE);
        return self::getDatabaseConfiguration();
    }
    public static function getDatabaseConfiguration()
    {
        if ( empty(self::$config_database) ) return FALSE;
        else return self::$config_database;
    }

    private static function load_module_files()
    {
        $install = config()->group('install');
        if ( $install ) {
            foreach( $install as $module ) {
                $path = "module/$module[value]/$module[value].module";
                include $path;
            }
        }
    }


    /**
     *
     * @deprecated What is the use of this method?
     * @return int
     *  - zero(0) if there is no error.
     *
     */
    public function check()
    {
        return 0;
        /*
        $markup = Markup::create();
        if ( ! self::install() ) {
            // return $markup->set('type','box.error')->set('code', ERROR_INSTALL)->set('message', 'System is not installed')->display();
        }
        return 0;
        */
    }

    public function theme()
    {
        $this->path = 'theme/'.$GLOBALS['theme'];
        return $this;
    }
    public function script($filename=null)
    {
        if ( empty($filename) ) $filename = $this->filename;
        $this->script = $this->path . '/' . $filename . '.php';
        return $this->script;
        // return PATH_INSTALL . '/core/etc/script.php';
    }

    public function module($module=null, $class=null)
    {
        $module = empty($module) ? Request::get('module') : $module;
        $class = empty($class) ? Request::get('class') : $class;
        $core = self::isCoreModule($module) ? "core/" : null;
        $this->path = "{$core}module/$module/src";
        $this->filename = $class;
        return $this;
    }


    /**
     * @param $str
     * @TODO @WARNING If the log file permission is not open to public, then it will create error.
     * @return int|void
     */
    public static function log ( $str )
    {
        if ( empty($str) ) return OK;

        $str = is_string($str) ? $str : print_r( $str, true );

        return File::append(PATH_LOG, self::$count_log++ . ' : ' . $str . "\n");
    }


}