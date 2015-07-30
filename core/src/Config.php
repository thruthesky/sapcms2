<?php
namespace sap\core;
use sap\core\module\Install\Install;

class Config
{
    private $file = null;
    private $data = null;

    public static function create()
    {
        return Entity::create('config');
    }
    public static function load($field=null, $value='idx')
    {
        return Entity::load('config', $field, $value);
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



    public static function initStorage()
    {
        dog(__METHOD__);
        Entity::init('config')
            ->add('code', 'varchar', 64)
            ->add('value', 'TEXT')
            ->unique('code');
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

    public function delete()
    {
        return File::delete($this->file);
    }
}