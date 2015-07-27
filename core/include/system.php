<?php
class System {
    static $version = '2.0.1';
    public static function load() {
        return new System();
    }
    public static function version() {
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
        return $GLOBALS['argv']['0'] == 'index.php';
    }
}