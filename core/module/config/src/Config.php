<?php
namespace sap\core\Config;
use sap\core\Install\Install;
use sap\src\File;
use sap\src\Meta;

define('CONFIG_TABLE', 'config');

class Config extends Meta
{
    private $file = null;
    private $data = null;



    public function __construct() {
        parent::__construct('config');
    }


    /**
     * @param $path
     * @return array
     */
    public static function read($path)
    {
        if ( file_exists($path) ) {
            include $path;
            $vars = get_defined_vars();
            return $vars;
        }
        else return FALSE;
    }



    public static function file($file) {
        Install::createDirs();
        $config = new Config();
        $config ->file = $file;
        return $config ;
    }


    /**
     * @param $data
     * @return $this
     */
    public function data($data) {
        $this->data = $data;
        return $this;
    }

    /**
     * @return int
     */
    public function saveFileConfig() {
        return File::save_in_php(
            $this->file,
            $this->data
        );
    }



    public static function getDatabasePath()
    {
        return PATH_CONFIG_DATABASE;
    }

    public function deleteFile()
    {
        return File::delete($this->file);
    }

    public function getUrlSite()
    {
        $url = config()->get('URL_SITE');
        if ( empty($ur) ) return '/';
        else return $url;
    }
}