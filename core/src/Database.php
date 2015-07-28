<?php
namespace sap\core;
class Database extends \PDO {

    protected $type = null;

    public function __construct($dsn, $username=null, $password=null) {
        parent::__construct($dsn, $username, $password);
    }

    public function mysql($host, $dbname, $username, $password) {
        parent::__construct("mysql:host=$host;dbname=$dbname", $username, $password);
        $this->setOptions();
        return $this;
    }

    public static function sqlite($path) {
        $db = new Database("sqlite:$path");
        $db->type = 'sqlite';
        $db->setOptions();
        return $db;
    }

    private function setOptions()
    {
        try
        {
            $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch (\PDOException $e)
        {
            die($e->getMessage());
        }
    }

    public function createTable($name) {
        $q = "CREATE TABLE $name (idx INTEGER PRIMARY KEY ASC);";
        $this->exec($q);
        return $this;
    }

    public function dropTable($name)
    {
        $q = "DROP TABLE $name;";
        $this->exec($q);
        return $this;
    }

    public function addColumn($name, $column, $type)
    {
        $q = "ALTER TABLE $name ADD COLUMN $column $type";
        $this->exec($q);
        return $this;
    }
}