<?php
namespace sap\core;
class Database extends \PDO {

    private static $db = null;
    private $create_table = null; // remember last create table
    public $type = null;

    public function __construct($dsn=null, $username=null, $password=null) {
        if ( empty($dsn) ) {

        }
        else parent::__construct($dsn, $username, $password);
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
        dog(__METHOD__);
        if ( self::$db ) return self::$db;
        $config = Config::read(PATH_CONFIG_DATABASE);
        dog("config:");
        dog($config);
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

    /**
     * @param null $create_table
     *
     * @return $this|null
     *
     *      - If $create_table is null, then it returns a string with table name.
     *
     *      - If $create_table is not null, then it returns $this.
     *
     */
    public function table($create_table=null) {
        if ( $create_table ) {
            $this->create_table = $create_table;
            return $this;
        }
        else return $this->create_table;
    }



    public function createTable($table) {
        $this->table($table);
        if ( $this->type == 'mysql' ) {
            $q = "CREATE TABLE $table (idx INT, created INT UNSIGNED DEFAULT 0, changed INT UNSIGNED DEFAULT 0) DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;";
            $this->exec($q);
            $this->addPrimaryKey($table, 'idx');
            $this->addAutoIncrement($table, 'idx');
        }
        else if ( $this->type == 'sqlite' ) {
            $q = "CREATE TABLE $table (idx INTEGER PRIMARY KEY, created INT UNSIGNED DEFAULT 0, changed INT UNSIGNED DEFAULT 0);";
            $this->exec($q);
        }

        $this->addIndex($table, 'created');
        $this->addIndex($table, 'changed');

        return $this;
    }

    public function dropTable($name)
    {
        $q = "DROP TABLE IF EXISTS $name;";
        $this->exec($q);
        return $this;
    }

    public function add($column, $type, $size=0)  {
        $table = $this->table();
        return $this->addColumn($table, $column, $type, $size);
    }
    public function addColumn($table, $column, $type, $size=0)
    {
        if ( empty($size) ) {
            if ( $type == 'varchar' || $type == 'char' ) $size = 255;
        }
        if ( $size ) $type = "$type($size)";
        $q = "ALTER TABLE $table ADD COLUMN $column $type";
        $this->exec($q);
        return $this;
    }
    public function deleteColumn($table, $column) {

        if ( $this->type == 'mysql' ) {
            $q = "ALTER TABLE $table DROP $column";
            $this->exec($q);
            return $this;
        }
        else if ( $this->type == 'sqlite' ) {
            // You can not delete a column in SQLite
            return FALSE;
        }
        else {
            $q = "ALTER TABLE $table DROP $column";
            $this->exec($q);
            return $this;
        }
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


    public function unique($fields) {
        return $this->addUniqueKey($this->table(), $fields);
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

    public function index($fields) {
        return $this->addIndex($this->table(), $fields);
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


    /**
     *
     *
     * @param $table
     * @param $cond
     * @param string $field
     * @return mixed
     *
     * @code
     *      $row = $this->row($this->table());
     * @endcode
     */
    public function row($table, $cond=1, $field='*')
    {
        $q = "SELECT $field FROM $table WHERE $cond LIMIT 1";
        dog($q);
        $statement = $this->query($q);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }



    /**
     * @param $table
     * @param $kvs
     * @return string
     */
    public function insert($table, $kvs)
    {

        $key_list = [];
        $value_list = [];
        foreach($kvs as $k => $v ) {
            $key_list[] = "`$k`";
            // @todo ESCAPE the value
            if ( $v === NULL ) {
                $value_list[] = "NULL";
            }
            else $value_list[] = "'$v'";
        }
        $keys = implode(",", $key_list);
        $values = implode(",", $value_list);
        $q = "INSERT INTO `{$table}` ({$keys}) VALUES ({$values})";
        dog($q);
        $result = $this->exec($q);
        $insert_id = $this->lastInsertId();
        return $insert_id;
    }

    /**
     * @param $table
     * @param $kvs
     * @param int $cond - a string of Where condition
     * @return \PDOStatement
     */
    public function update($table, $kvs, $cond=1)
    {
        $sets = [];
        foreach($kvs as $k => $v) {
            // @todo ESACPE the value
            $sets[] = "`$k`='$v'";
        }
        $set = implode(", ", $sets);
        $q = "UPDATE $table SET $set WHERE $cond";
        dog($q);
        $statement = $this->query($q);
        return $statement;
    }


    public function delete($table, $cond)
    {
        $q = "DELETE FROM $table WHERE $cond";
        dog($q);
        $statement = $this->query($q);
        return OK;
    }


    /**
     * @param $field
     * @return bool
     *  - TRUE if the key exists on the table
     */
    public function columnExists($table, $field=null) {
        dog(__METHOD__);
        if ( empty($field) ) {
            $field = $table;
            $table = $this->table();
        }
        dog("$table:$table, field:$field");
        try {
            $this->row($table, "$field=1");
            return TRUE;
        }
        catch(\PDOException $e) {
            return FALSE;
        }
    }
}