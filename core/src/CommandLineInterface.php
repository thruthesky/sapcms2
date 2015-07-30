<?php
namespace sap\core;
class CommandLineInterface {
    static $arg = [];
    static $argv = [];
    static $argc = 0;
    static $cmd = null;
    public static function parseArguments()
    {
        self::$argv = $GLOBALS['argv'];
        self::$argc = $GLOBALS['argc'];
        self::$cmd = isset(self::$argv[1]) ? self::$argv[1] : null;

        if ( self::$argc > 1 ) {
            for( $i=1; $i<self::$argc; $i++ ) {
                $arr = explode('=', self::$argv[$i], 2);
                if ( isset($arr[1]) ) {
                    self::$arg[$arr[0]] = $arr[1];
                }
                else self::$arg[$arr[0]] = null;
            }
        }
    }
    public static function Run() {
        dog(__METHOD__);
        self::parseArguments();
        if ( empty(self::$cmd) ) {
        }
        else if ( self::$cmd == '--help' ) self::displayHelp();
        else if ( self::$cmd == '--version' ) {
            echo System::version();
        }
        else if ( self::$cmd == '--install' ) {
            System::install([
                'database' => self::getArgument('--database'),
                'database-host' => self::getArgument('--database-host'),
                'database-name' => self::getArgument('--database-name'),
                'database-username' => self::getArgument('--database-username'),
                'database-password' => self::getArgument('--database-password'),
                'admin-user-id' => self::getArgument('--admin-user-id'),
                'admin-password' => self::getArgument('--admin-password'),
            ]);
        }
        else {
            $pi = pathinfo(self::$cmd);
            if ( $pi['extension'] == 'php' ) {
                include self::$cmd;
            }
        }
        return OK;
    }
    public static function displayHelp() {
        echo <<<EOH
--version\tShows version.
--install\tInstalls SAPCMS2
\t\t--database=[SQLite|MySQL]
\t\t--database-host=[localhost|domain|IP Address]
\t\t--database-username=[SQLite|MySQL]
\t\t--database-password=[SQLite|MySQL]
\t\t--database-name=[SQLite|MySQL]
\t\t--admin-user-id=[SQLite|MySQL]
\t\t--admin-password=[SQLite|MySQL]
\t\tFor SQLite, you do not need to supply database user information and database filename.
\t\tFor instance, "sap --install --database=SQLite --admin-user-id=abc --admin-password=def"
EOH;
    }

    private static function getArgument($k)
    {
        return isset(self::$arg[$k]) ? self::$arg[$k] : null;
    }

}
