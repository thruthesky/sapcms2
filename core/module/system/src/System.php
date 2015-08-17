<?php
namespace sap\core\System;
use sap\core\config\Config;
use sap\core\install\Install;
use sap\core\user\User;
use sap\src\CommandLineInterface;
use sap\src\Database;
use sap\src\File;
use sap\src\Module;
use sap\src\Request;
use sap\src\Response;
use sap\src\Route;

/**
 *
 *
 */
class System {
    static $system = null;
    static $version = '2.0.1';
    private static $count_log = 0;
    private static $config_database = null;
    private static $error;
    private static $module_loaded = [];
    private static $cli = false;
    private static $done_cli_check = false;
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

    public static function info() {
        echo self::$version;
        echo '<hr>';
        phpinfo();
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
        Install::submit($options);
    }





    public static function isCommandLineInterface()
    {
        if ( self::$done_cli_check ) return self::$cli;
        self::$done_cli_check = true;
        if ( isset($GLOBALS['argc']) && $GLOBALS['argc'] > 0 ) self::$cli = true;
        if ( isset($GLOBALS['argv']) ) {
            if ( $GLOBALS['argv']['0'] == 'index.php' ) self::$cli = true;
        }
        if ( defined('CommandLineInterfaceMode') ) {
            self::$cli = true;
        }
        return self::$cli;
    }


    /**
     * @return int
     */
    public static function run()
    {


        if ( System::isCommandLineInterface() && CommandLineInterface::getCommand() == '--uninstall' )  {

        }
        else {
            self::load();
            self::loadDatabaseConfiguration();
            self::load_core_module_files();
            if ( Install::check() ) {
                self::load_module_files();
            }
        }
        hook('system_begin');



        /**
         * Return after loading System and its core libraries,
         *  if it is running on CLI without checking Installation and running further.
         */
        if ( System::isCommandLineInterface() ) {
            $re = CommandLineInterface::Run();
        }
        else if ( ! Install::check() ) {
            $re = Install::runInstall();
            exit; // @todo it should not exit here.
        }
        else {
            $re = Module::run();
        }

        hook('system_end');
        return $re;
    }

    private static function load_module_files()
    {

        $install = config()->group('module')->gets();

        if ( $install ) {
            foreach( $install as $code => $module ) {
                self::addModuleLoaded($module);
                $path = "module/$module/$module.module";
                $variables = ['module'=>$module, 'path'=>$path];
                hook('before_module_load', $variables);
                /**
                 * It uses 'include_once' instead of 'include', since there might be changes to 're-include' same script
                 *      just like when you include a module file here and you include it again on enabling/disabling the module.
                 */
                include_once $path;
                hook('after_module_load', $variables);
            }
            hook('module_load_complete');
        }
    }
    private static function load_core_module_files()
    {
        foreach ( self::getCoreModules() as $module ) {
            self::addModuleLoaded($module);
            $path = "core/module/$module/$module.module";
            if ( file_exists($path) ) {
                include $path;
                $variables = ['module'=>$module, 'path'=>$path];
                hook('core_module_load', $variables);
            }
        }
        hook('core_module_load_complete');
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


    /**
    public static function isInstalled($flag=null)
    {
        if ( $flag === null ) return self::$isInstalled;
        else return self::$isInstalled = $flag;
    }
     * */


    /**
     *
     * Save an error with message.
     *
     * @param $code
     * @param array $array_kvs
     * @return mixed
     */
    public static function error($code, $array_kvs=[])
    {
        $msg = get_error_message($code);
        if ( $array_kvs ) {
            foreach( $array_kvs as $k => $v ) {
                $msg = str_replace('#'.$k, $v, $msg);
            }
        }
        self::$error[$code] = $msg;
        System::error_log("$code:$msg");
        return $code;
    }

    /**
     *
     * It adds a real-time error message.
     *      - You can use System::getError() to display to user.
     *
     * @param $code
     * @param $message
     * @return mixed - The code
     *
     * @code
     *      System::setError(-1234, "Error Message");
            print_r(System::getError());
     * @endcode
     *
     */
    public static function setError($code, $message) {
        global $error_message;
        $error_message[$code] = $message;
        self::$error[$code] = $message;
        return $code;
    }

    /**
     *
     * Returns all the error messages that was generated by run.
     *
     *
     *
     *
     *
     * @return mixed
     */
    public static function getError() {
        return self::$error;
    }

    private static function addModuleLoaded($module)
    {
        self::$module_loaded[] = $module;
    }

    /**
     *
     * Returns an array of module that are installed(enabled)
     *
     * @return array
     */
    public static function getModuleLoaded()
    {
        return self::$module_loaded;
    }

    /**
     * Returns TRUE if the input $module_name is installed(enabled)
     *
     *      - if it is a core module, then it will return true.
     *
     * @param $module_name
     * @return bool
     */
    public static function isEnabled($module_name) {
        if ( Module::isCoreModule($module_name) ) return true;
        return in_array($module_name, self::$module_loaded);
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
        if ( ! Install::check() ) return OK;
        if ( empty($str) ) return OK;
        $str = is_string($str) ? $str : print_r( $str, true );
        return @File::append(PATH_DEBUG_LOG, self::$count_log++ . ' : ' . $str . "\n");
    }

    /**
     * @param $str
     * @TODO @WARNING If the log file permission is not open to public, then it will create error.
     * @return int|void
     */
    public static function error_log ( $str )
    {
        if ( empty($str) ) return OK;
        $str = is_string($str) ? $str : print_r( $str, true );
        return File::append(PATH_ERROR_LOG, $str . "\n");
    }


}
