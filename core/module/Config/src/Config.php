<?php
namespace sap\core;


use sap\core\Install;
use sap\src\File;
use sap\src\Meta;

class Config extends Meta
{
    private $file = null;
    private $data = null;


    public function __construct() {
        parent::__construct('config');
    }
    public static function initStorage()
    {
        dog(__METHOD__);
        $config = new Config();
        $config->install();
    }
    public static function load() {
        return new Config();
    }

    /**
     * @param $path
     * @return array
     */
    public static function read($path)
    {
        dog(__METHOD__ . " : $path");
        if ( file_exists($path) ) {
            include $path;
            return get_defined_vars();
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
    public function save() {
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

}