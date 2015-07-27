<?php
class System {
    static $version = '2.0.1';
    private $path = null;
    private $filename =null;
    public $script = null;

    public static function load() {
        return new System();
    }
    public static function version()
    {
        return self::$version;
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
            return $GLOBALS['argv']['0'] == 'index.php';
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
            return $markup->set('type','box.error')->set('code', ERROR_INSTALL)->set('message', 'System is not installed')->display();
        }
        // Response::HTML( Error::fatal() );

        //return 0;
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
        return PATH_INSTALL . '/core/etc/script.php';
    }

    public function module($core=false)
    {
        if ( $core ) $core = "core/";
        $this->path = "{$core}module/" . Request::get('module');
        $this->filename = Request::get('action');
        return $this;
    }

}