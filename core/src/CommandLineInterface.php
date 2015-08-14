<?php
namespace sap\src;
use sap\core\Config\Config;
use sap\core\Install\Install;
use sap\core\System\System;

class CommandLineInterface {
    static $arg = [];
    static $argv = [];
    static $argc = 0;
    static $cmd = null;
    public static function parseArguments()
    {
        if ( ! empty( self::$cmd ) ) return;
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

    public static function getCommand() {
        self::parseArguments();
        return self::$cmd;
    }


    /**
     *
     *
     * @return int
     *
     *
     */
    public static function Run() {
        System::log(__METHOD__);
        self::parseArguments();
        if ( empty(self::$cmd) ) {
        }
        else if ( self::$cmd == '--help' ) self::displayHelp();
        else if ( self::$cmd == '--version' ) {
            echo System::version();
        }
        else if ( self::$cmd == '--install' ) {

            //print_r(self::getArguments());
            //di('hi');exit;

            System::install([
                'database' => self::getArgument('--database'),
                'database_host' => self::getArgument('--database-host'),
                'database_name' => self::getArgument('--database-name'),
                'database_username' => self::getArgument('--database-username'),
                'database_password' => self::getArgument('--database-password'),
                'admin-id' => self::getArgument('--admin-id'),
                'admin-password' => self::getArgument('--admin-password'),
            ]);
        }
        else if ( self::$cmd == '--uninstall' ) {
            File::delete(PATH_CONFIG_DATABASE);
        }
        else if ( self::$cmd == '--config' ) {
            $args = self::getArguments();
            foreach( $args as $code => $value ) {
                if ( self::$cmd == $code ) {

                }
                else if ( $code == '--delete' ) {
                    config()->delete($value);
                }
                else if ( ! empty($value) ) {
                    config()->set($code, $value);
                }
                else {
                    echo config()->get($code) . PHP_EOL;
                }
            }
        }
        else if ( self::$cmd == '--enable' ) {
            $name = self::segment(2);
            echo "Enabling module : $name\n";
            $code = Install::enableModule($name);
            if ( $code ) {
                echo get_error_message($code);
            }
        }
        else if ( self::$cmd == '--disable' ) {
            $name = self::segment(2);
            echo "Disabling module : $name\n";
            $code = Install::disableModule($name);
            if ( $code ) echo get_error_message($code);
        }
        else if ( self::$cmd == '--list-module') {
            foreach ( System::getModuleLoaded() as $module ) {
                echo "$module\n";
            }
        }
        else {
            if ( self::$cmd ) {
                $path = self::$cmd;
                $pi = pathinfo($path);
                if ( isset($pi['extension']) && $pi['extension'] == 'php' ) {
                    $module = get_module_from_path($path);
                    if ( $module ) {
                        if ( System::isEnabled($module) ) include $path;
                        else {
                            echo "Module [ $module ] is not enabled.";
                        }
                    }
                    else {
                        include $path;
                    }
                }
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

    private static function segment($n) {
        return isset(self::$argv[$n]) ? self::$argv[$n] : FALSE;
    }

    private static function getArguments()
    {
        return self::$arg;
    }
}
