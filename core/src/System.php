<?php
class System {
    static $system = null;
    static $version = '2.0.1';
    private $path = null;
    private $filename =null;
    public $script = null;

    public static function load() {
        if ( empty(self::$system) ) self::$system = new System();
        return self::$system;
    }
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
        include self::loadModuleClass($module, $class);
        $class::$method();
    }
    public static function loadModuleClass($module, $class) {
        return System::get()
            ->module($module, $class)
            ->script();
    }

    public static function isCoreModule($module=null)
    {
        if ( empty($module) ) $module = Request::get('module');
        return in_array($module, ['File-upload', 'Install', 'Post', 'User']);
    }

    private static function getDatabaseConfigPath()
    {
        return PATH_DATA . '/config.database.php';
    }

    public function install()
    {
        return file_exists(self::getDatabaseConfigPath());
    }

    public function runOnCommandLineInterface()
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
     * @return int
     *  - zero(0) if there is no error.
     */
    public function check()
    {
        $markup = Markup::create();
        if ( ! self::install() ) {
            // return $markup->set('type','box.error')->set('code', ERROR_INSTALL)->set('message', 'System is not installed')->display();
        }

        return 0;
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