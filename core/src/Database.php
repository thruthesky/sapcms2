<?php
namespace sap\src;
use sap\core\Config\Config;
use sap\core\System\System;

class Database extends \PDO {

    private static $db = null;
    private static $db_reset = null;
    private $work_table = null; // remember last create table
    public $type = null;

    public function __construct($dsn=null, $username=null, $password=null) {
	
        if ( empty($dsn) ) return;

        try {		
            parent::__construct($dsn, $username, $password);			
        }
        catch (\PDOException $e) {
            echo "<h1>Database Connection Error</h1>";
            echo $e->getMessage();
            echo "
            <ul>
            <li>dsn:$dsn</li>
            <li>username:$username</li>
            <li>password:$password</li>
            <li>Check database configuration file if it has correct information</li>
            </ul>
            ";
            throw new \Exception('Connection failed.');
        }
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



    /**
     * Sets PDO Options
     */
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

        $config = System::getDatabaseConfiguration();
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
        else {
            echo"\n" .  __METHOD__ . '<hr>';
            echo "\nERROR: " . get_error_message(ERROR_SYSTEM_NOT_INSTALLED);
            exit;
        }
    }

    /**
     * @param null $work_table
     * @return $this|null - If $work_table is null, then it returns a string with table name.
     *
     * - If $create_table is null, then it returns a string with table name.
     *
     * - If $create_table is not null, then it returns $this.
     *
     */
    public function table($work_table=null) {
        if ( $work_table ) {
            $this->work_table= $work_table;
            return $this;
        }
        else return $this->work_table;
    }



    public function createTable($table) {
        $this->table($table);
        if ( $this->type == 'mysql' ) {
            $q = "CREATE TABLE $table (idx INT) DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;";
            $this->runExec($q);
            $this->addPrimaryKey($table, 'idx');
            $this->addAutoIncrement($table, 'idx');
        }
        else if ( $this->type == 'sqlite' ) {
            $q = "CREATE TABLE $table (idx INTEGER PRIMARY KEY);";
            $this->runExec($q);
        }


        return $this;
    }

    public function dropTable($name)
    {
        $q = "DROP TABLE IF EXISTS $name;";
        $this->runExec($q);
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
        $this->runExec($q);
        return $this;
    }


    public function log($q) {
        system_log($q);
    }
    public function runExec($q) {
        $this->log($q);
        try
        {
            return $this->exec($q);
        }
        catch (\PDOException $e)
        {
            die($e->getMessage());
        }
    }
    public function runQuery($q) {
        $this->log($q);
        try
        {
            return $this->query($q);
        }
        catch (\PDOException $e)
        {
            die($e->getMessage());
        }
    }


    /**
     * @param $table
     * @param $column
     * @return $this|bool
     *
     * @Attention - You cannot delete a column with SQLite.
     */
    public function deleteColumn($table, $column) {

        if ( $this->type == 'mysql' ) {
            $q = "ALTER TABLE $table DROP $column";
            $this->runExec($q);
            return $this;
        }
        else if ( $this->type == 'sqlite' ) {
            // You can not delete a column in SQLite
            return FALSE;
        }
        else {
            $q = "ALTER TABLE $table DROP $column";
            $this->runExec($q);
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
            $this->runExec($q);
            return $this;
        }
        else if ( $this->type == 'sqlite' ) {
            // you alter add primary key in sqlite
            return $this;
        }
        else {
            $q = "ALTER TABLE $table ADD PRIMARY KEY ($fields)";
            $this->runExec($q);
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
            $this->runExec($q);
            return $this;
        }
        else if ( $this->type == 'sqlite' ) {
            $index_name = str_replace(',', '_', $fields);
            $q = "CREATE UNIQUE INDEX {$table}_$index_name ON $table ($fields);";
            $this->runExec($q);
            return $this;
        }
        else {
            $q = "ALTER TABLE $table ADD UNIQUE KEY ($fields)";
            $this->runExec($q);
            return $this;
        }
    }

    public function index($fields) {
        return $this->addIndex($this->table(), $fields);
    }
    public function addIndex($table, $fields) {

        if ( $this->type == 'mysql' ) {
            $q = "ALTER TABLE $table ADD INDEX ($fields)";
            $this->runExec($q);
            return $this;
        }
        else if ( $this->type == 'sqlite' ) {
            $index_name = str_replace(',', '_', $fields);
            $q = "CREATE INDEX {$table}_$index_name ON $table ($fields);";
            $this->runExec($q);
            return $this;
        }
        else {
            $q = "ALTER TABLE $table ADD UNIQUE KEY ($fields)";
            $this->runExec($q);
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
        $this->runExec($q);
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
     *      $row = $this->row($this->table()); // returns the first row
     *      $row = $db->row('temp', "name='JaeHo Song'");
     *      $row = $db->row('temp', db_and()->condition('name','JaeHo Song'));
     *      $row = $db->row('temp', db_cond('name','JaeHo Song'));
     * @endcode
     *
     * @Attention
     *
     */
    public function row($table, $cond=null, $field='*')
    {

        $cond = $this->adjustCondition($cond);

        if ( strpos($cond,'LIMIT') === false ) $cond .= " LIMIT 1";
        $q = "SELECT $field FROM $table $cond";
        $statement = $this->runQuery($q);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }


    /**
     * @param $table
     * @param null $cond
     * @param string $field
     * @param null $fetch_mode
     * @return array
     */
    public function rows($table, $cond=null, $field='*', $fetch_mode=null)
    {
        if ( $fetch_mode === null ) $fetch_mode = \PDO::FETCH_ASSOC;
        $cond = $this->adjustCondition($cond);
        $q = "SELECT $field FROM $table $cond";
        $statement = $this->runQuery($q);
        return $statement->fetchAll($fetch_mode);
        /*
        $rows = [];
        while ( $row = $statement->fetch($fetch_mode) ) {
            $rows[] = $row;
        }
        return $rows;
        */
    }



    /**
     *
     * Returns the first element of the first row.
     *
     * @param $table
     * @param $field
     * @param null $cond
     * @return mixed
     *
     * @code
     *      echo $db->result('sms_numbers'); // return the first element of the first row in the table
     *      echo $db->result('sms_numbers', 'count(*)'); // return the number of record of the table
     *      echo $db->result('sms_numbers', 'count(*)', 'idx >= 123');
     *      echo $db->result('sms_numbers', 'idx, stamp_last_sent', 'idx >= 123'); // return 123
     * @endcode
     *
     */
    public function result($table, $field='*', $cond=null) {
        $row = $this->row($table, $cond, $field);
        if ( $row ) {
            foreach( $row as $k => $v ) {
                return $v;
            }
        }
        return null;
    }

    /**
     *
     * Returns the number of record based on the condition
     *
     * @param $table
     * @param null $cond
     * @return mixed
     *
     * @code
     *      echo $db->count('sms_numbers');
     *      echo $db->count('sms_numbers', 'idx >= 1000');
     * @endcode
     */
    public function count($table, $cond=null) {
        return $this->result($table, "COUNT(*)", $cond);
    }


    /**
     * @param $table
     * @param array $keys_and_values
     * @return string
     *
     * @Attention When a value of a string is longer than then field character limit, it will cut off the last part of the string.
     *      - This is the nature of PDO.
     */
    public function insert($table, array $keys_and_values)
    {
        $key_list = [];
        $value_list = [];
        foreach($keys_and_values as $k => $v ) {
            $key_list[] = "`$k`";

            if ( $v === NULL ) {
                $value_list[] = "NULL";
            }
            else {
                $value_list[] = $this->quote($v);
            }
        }
        $keys = implode(",", $key_list);
        $values = implode(",", $value_list);
        $q = "INSERT INTO `{$table}` ({$keys}) VALUES ({$values})";
        $count = $this->runExec($q);
        if ( $count == 0 ) {
            return FALSE;
        }
        else {

        }
        $insert_id = $this->lastInsertId();
        return $insert_id;
    }

    /**
     * @param $table
     * @param $fields
     * @param int $cond
     * @return \PDOStatement
     */
    public function update($table, $fields, $cond=null)
    {
        $sets = [];
        foreach($fields as $k => $v) {
            $sets[] = "`$k`=" . $this->quote($v);
        }
        $set = implode(", ", $sets);
        $where = null;
        if ( $cond ) $where = "WHERE $cond";
        $q = "UPDATE $table SET $set $where";
        $statement = $this->runQuery($q);
        return $statement;
    }


    /**
     * @param $table
     * @param $cond
     * @return int
     */
    public function delete($table, $cond)
    {
        $q = "DELETE FROM $table WHERE $cond";
        $statement = $this->runQuery($q);
        return OK;
    }



    /**
     * @param $field
     * @return bool
     *  - TRUE if the key exists on the table
     *
     * @code
     *      Database::load()->columnExists('temp', 'idx')
     * @endcode
     */
    public function columnExists($table, $field=null) {
        if ( empty($field) ) {
            $field = $table;
            $table = $this->table();
        }
        try {
            $this->query("SELECT $field FROM $table LIMIT 1");
            return TRUE;
        }
        catch(\PDOException $e) {
            return FALSE;
        }
    }
    public function tableExists($table) {
        try {
            $this->query("SELECT * FROM $table");
            return TRUE;
        }
        catch(\PDOException $e) {
            return FALSE;
        }
    }

    private function adjustCondition($cond)
    {
        if ( $cond === null ) $cond = null;
        else {
            $cond = trim($cond);
            if ( stripos($cond, 'ORDER') === 0 || stripos($cond, 'GROUP') === 0 || stripos($cond, 'LIMIT') === 0 ) {

            }
            else {
                $cond = "WHERE $cond";
            }
        }
        return $cond;
    }

    public function reset()
    {
        Database::$db_reset = Database::$db;
        Database::$db = $this;
    }

    public function restore()
    {
        Database::$db = Database::$db_reset;
    }


}