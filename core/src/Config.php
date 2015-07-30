<?php
namespace sap\core;
use sap\core\module\Install\Install;

class Config
{
    private $file = null;
    private $data = null;
    public static function create() {
        Install::createDirs();
        return new Config();
    }

    /**
     * @param $path
     * @return array
     */
    public static function load($path)
    {
        dog(__METHOD__);
        include $path;
        return get_defined_vars();
    }

    public static function createTable()
    {
        $db = Database::load();
        $db->dropTable('config');
        $db->createTable('config');
        $db->addColumn('config', 'code', 'varchar', 65);
        $db->addColumn('config', 'value', 'TEXT');
        $db->addUniqueKey('config', 'code');
    }

    public function file($file) {
        $this->file = $file;
        return $this;
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
}