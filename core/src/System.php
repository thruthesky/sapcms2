<?php
namespace sap\core;

class System {
    static $system = null;
    static $version = '2.0.1';
    private $path = null;
    private $filename =null;
    public $script = null;

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

    public static function runModule()
    {
        //$path = module_script();
        //include $path;
        $module = Request::get('module');
        $class = Request::get('class');
        $method = Request::get('method');
        //include self::loadModuleClass($module, $class);
        $core = is_core_module() ? "core\\" : null;
        //echo "<h1>$module</h1>";
        $name = "sap\\{$core}module\\$module\\$class";
        //echo "<h1>name:$name</h1>";
        $name::$method();
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
        Config::create()
            ->file(PATH_DATABASE_CONFIG)
            ->data($options)
            ->save();
        self::createDatabase($options);
        /*
        User::create()
            ->set('username', 'admin')
            ->set('password', '1234')
            ->save();
        */
    }

    private static function createDatabase($options)
    {
        $db = Database::sqlite(PATH_SQLITE_DATABASE);
        $db->dropTable('user');
        $db->createTable('user');
        $db->addColumn('user', 'id', 'varchar(64)');
        $db->addColumn('user', 'password', 'varchar(64)');
        $db->addColumn('user', 'username', 'varchar(64)');
        $db->addColumn('user', 'nickname', 'varchar(64)');
        $db->addColumn('user', 'email', 'varchar(64)');
        $db->addColumn('user', 'birth_year', 'int');
        $db->addColumn('user', 'birth_month', 'int');
        $db->addColumn('user', 'day', 'int');

    }

    private static function getDatabaseConfigPath()
    {
        return PATH_DATA . '/config.database.php';
    }

    /**
     * @return bool
     *  - return true if the system is installed.
     *  - otherwise, returns false.
     */
    public function isInstalled()
    {
        return file_exists(self::getDatabaseConfigPath());
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

}