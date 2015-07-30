<?php
namespace sap\core;
class Database extends \PDO {

    private static $db = null;
    protected $type = null;

    public function __construct($dsn, $username=null, $password=null) {
        parent::__construct($dsn, $username, $password);
    }


    public static function mysql($host, $dbname, $username, $password) {
        $db = new Database("mysql:host=$host;dbname=$dbname", $username, $password);
        $db->type = 'mysql';
        $db->setOptions();
        return $db;
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

    /**
     *
     * @Attention It only creates a single object and re-use it.
     *
     * @return bool|null|Database
     */
    public static function load()
    {
        if ( self::$db ) return self::$db;
        $config = Config::load(PATH_CONFIG_DATABASE);
        $type = strtolower($config['database']);
        if ( $type == 'sqlite' ) {
            return self::$db = Database::sqlite(PATH_SQLITE_DATABASE);
        }
        else if ( $type == 'mysql' ) {
            return self::$db = Database::mysql(
                $config['database_host'],
                $config['database_name'],
                $config['database_username'],
                $config['database_password']
            );
        }
        else return FALSE;
    }



    public function createTable($table) {
        if ( $this->type == 'mysql' ) {
            $q = "CREATE TABLE $table (idx INT, created INT UNSIGNED DEFAULT 0, changed INT UNSIGNED DEFAULT 0) DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;";
            $this->exec($q);
            $this->addPrimaryKey($table, 'idx');
            $this->addAutoIncrement($table, 'idx');
            $this->addIndex($table, 'created');
            $this->addIndex($table, 'changed');
        }
        else if ( $this->type == 'sqlite' ) {
            $q = "CREATE TABLE $table (idx INTEGER PRIMARY KEY, created INT UNSIGNED DEFAULT 0, changed INT UNSIGNED DEFAULT 0);";
            $this->exec($q);
            $this->addIndex($table, 'created');
            $this->addIndex($table, 'changed');
        }
        return $this;
    }

    public function dropTable($name)
    {
        $q = "DROP TABLE IF EXISTS $name;";
        $this->exec($q);
        return $this;
    }

    public function addColumn($name, $column, $type, $size=0)
    {
        if ( $size ) $type = "$type($size)";
        $q = "ALTER TABLE $name ADD COLUMN $column $type";
        $this->exec($q);
        return $this;
    }

    public function row($table, $field, $value)
    {
        $q = $this->prepare("SELECT * FROM $table WHERE `$field`=:$field");
        $q->bindValue(":$field", $value);
        $q->execute();
        return $q->fetch(\PDO::FETCH_ASSOC);

        /*
        $this->queryType = 'SELECT';
        $this->table = $table;
        $this->fields = '*';
        return $this;
        */
    }

    /**
     * @param $table
     * @param $kvs
     * @return string
     */
    public function insert($table, $kvs)
    {

        foreach($kvs as $k => $v ) {
            $key_list[] = $k;
            $value_list[] = $v; // @todo ESACPE the value
        }
        $keys = "`".implode("`,`",$key_list)."`";
        $values = "'".implode("','",$value_list)."'";
        $q = "INSERT INTO `{$table}` ({$keys}) VALUES ({$values})";

        $result = $this->exec($q);
        $insert_id = $this->lastInsertId();
        return $insert_id;
    }

    /**
     * @param $table
     * @param $kvs
     * @param int $where - a string of Where condition
     * @return \PDOStatement
     */
    public function update($table, $kvs, $where=1)
    {
        $sets = [];
        foreach($kvs as $k => $v) {
            // @todo ESACPE the value
            $sets[] = "`$k`='$v'";
        }
        $set = implode(", ", $sets);
        $q = "UPDATE $table SET $set WHERE $where";
        $statement = $this->query($q);
        return $statement;
    }

    /**
     * Adds primary key on the table
     *
     * @param $table
     * @param $fields
     * @return $this
     *
     * @code
     *  $this->addPrimaryKey($name, 'idx');
     *  $this->addPrimaryKey($name, 'idx,name'); // can be two column.
     * @endcode
     */
    public function addPrimaryKey($table, $fields)
    {
        if ( $this->type == 'mysql' ) {
            $q = "ALTER TABLE $table ADD PRIMARY KEY ($fields)";
            $this->exec($q);
            return $this;
        }
        else if ( $this->type == 'sqlite' ) {
            // you alter add primary key in sqlite
            return $this;
        }
        else {
            $q = "ALTER TABLE $table ADD PRIMARY KEY ($fields)";
            $this->exec($q);
            return $this;
        }
    }

    public function addUniqueKey($table, $fields)
    {
        if ( $this->type == 'mysql' ) {
            $q = "ALTER TABLE $table ADD UNIQUE KEY ($fields)";
            $this->exec($q);
            return $this;
        }
        else if ( $this->type == 'sqlite' ) {
            $index_name = str_replace(',', '_', $fields);
            $q = "CREATE UNIQUE INDEX {$table}_$index_name ON $table ($fields);";
            $this->exec($q);
            return $this;
        }
        else {
            $q = "ALTER TABLE $table ADD UNIQUE KEY ($fields)";
            $this->exec($q);
            return $this;
        }
    }

    public function addIndex($table, $fields) {

        if ( $this->type == 'mysql' ) {
            $q = "ALTER TABLE $table ADD INDEX ($fields)";
            $this->exec($q);
            return $this;
        }
        else if ( $this->type == 'sqlite' ) {
            $index_name = str_replace(',', '_', $fields);
            $q = "CREATE INDEX {$table}_$index_name ON $table ($fields);";
            dog($q);
            $this->exec($q);
            return $this;
        }
        else {
            $q = "ALTER TABLE $table ADD UNIQUE KEY ($fields)";
            $this->exec($q);
            return $this;
        }

    }



    public function addAutoIncrement($table, $field) {
        if ( $this->type == 'mysql' ) {
            $q = "ALTER TABLE `$table` MODIFY COLUMN `$field` INT AUTO_INCREMENT;";
        }
        else {
            $q = "ALTER TABLE `$table` MODIFY COLUMN `$field` INT AUTO_INCREMENT;";
        }
        $this->exec($q);
        return $this;
    }

    /*
    public function condition($field, $value, $exp) {
        $this->condition[$field] = $value;
        $this->expression[$field] = $exp;
        return $this;
    }
    public function execute() {
        if ( $this->queryType == 'SELECT' ) {
            $q = $this->prepare("SELECT $fields FROM user WHERE id=:id");
        }
        $q->bindValue(':id', 'admin', \PDO::PARAM_STR);
        $q->execute();
        $row = $q->fetch(\PDO::FETCH_ASSOC);
    }
    */
}