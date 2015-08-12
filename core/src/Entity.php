<?php
namespace sap\src;


use sap\core\System\System;

class Entity {
    private static $loadCache = [];
    private static $loadCacheIdx = [];
    public $fields = [];
    private $cacheCode = null;
    private $table = null;

    public function __construct($table = null) {
        $this->table = $table;
    }


    /**
     *
     * @return string - If $work_table is null, then it returns a string with table name.
     *
     */
    final public function table() {
        return $this->table;
    }


    /**
     * Creates an Entity table.
     *
     * @return bool|null|Database
     */
    public function createTable() {
        if ( empty($table) ) $table = $this->table();
        $db = Database::load();
        $db->dropTable($table);
        $db->createTable($table);
        $db->add('created', 'INT UNSIGNED DEFAULT 0');
        $db->add('changed', 'INT UNSIGNED DEFAULT 0');
        $db->addIndex($table, 'created');
        $db->addIndex($table, 'changed');

        return $db;
    }

    final public function dropTable() {
        if ( empty($table) ) $table = $this->table();
        $db = Database::load();
        $db->dropTable($table);
        return OK;
    }


    final public function loadTable() {
        if ( empty($table) ) $table = $this->table();
        $db = Database::load();
        $db->table($table);
        return $db;
    }


    /**
     * @param array $options
     * @return mixed
     */
    public function create($options=[]) {
        $this->set('idx', NULL);
        $this->set('created', isset($options['created']) ? $options['created'] : time());
        $this->set('changed', isset($options['changed']) ? $options['changed'] : time());
        hook('entity_create', $this);
        return $this;
    }

    /**
     *
     * Returns $this after loading Entity.
     *
     *      - return FALSE if no Entity found.
     *
     *          -- AND the not-found-Entity is not cached. So, on next call, it will access database again.
     *
     *
     *      - You can check with 'empty()', 'false'.
     *
     * @Attention It memory caches. So you can call this method as much as you can.
     *
     * @param null $field
     * @param null $value
     * @return Entity
     */
    final public function load($field, $value=null) {

        $table = $this->table();
        $code = "$table:$field:$value";
        System::log(__METHOD__ . " ( $field, $value ) : $code");

        $this->setCacheCode($code);

        if ( $this->cached($code) ) { // alredy cached?
            $this->fields = $this->getCache($code); // get data.
            if ( empty($this->fields) ) { // cached but data is empty.
                return FALSE;
            }
            else {
                return $this;
            }
        }

        $data = $this->loadData($field, $value);

        if ( $data ) {
            hook('entity_load', $this);
            $this->setCache($this->getCacheCode(), $data);
            return $this;
        }
        else return FALSE;

    }



    /**
     * @param null $field
     * @return array|null
     *
     *  - if $field has a field name, then it returns the value of the field.
     *
     *  - if $field is null, then it returns the whole field array.
     *
     */
    final public function get($field=null)
    {
        if ( $field ) {
            return isset($this->fields[$field]) ? $this->fields[$field] : null;
        }
        else {
            return $this->fields;
        }
    }

    /**
     * @param $field
     * @param $value
     * @return $this
     *
     *
     * @code
     * Entity::create($table)
    ->set(['a'=>1, 'b'=>'2', 'c'=>3])
    ->save();
     * @endcode
     *
     */
    public function set($field, $value=null)
    {
        if ( is_array($field) ) {
            $this->fields = array_merge($this->fields, $field);
        }
        else $this->fields[$field] = $value;
        return $this;
    }

    /**
     *
     * Encrypt the input (plain-text) password and save into 'password' field.
     *
     * @Attention This methods can be used only if the Entity has 'password fields'
     *
     * @param $plain_text_password
     * @return $this
     */
    final public function setPassword($plain_text_password)
    {
        if ( empty($plain_text_password) ) return error(ERROR_PASSWORD_IS_EMPTY);
        $this->fields['password'] = encrypt_password($plain_text_password);
        return $this;
    }

    /**
     *
     * Checks the password.
     *
     * @param $plain_text_password
     * @return bool
     *
     * @Attention
     *
     *      - FALSE is returned on wrong password.
     *
     *      - TRUE is returned on correct password.
     */
    public function checkPassword($plain_text_password)
    {
        if ( empty($plain_text_password) ) return FALSE;
        return $this->fields['password'] == encrypt_password($plain_text_password);
    }



    /**
     *
     * @Attention it returns FALSE on error which is derived from PDO::exec()
     *
     * @return $this
     *
     *
     */
    public function save()
    {
        if ( $this->get('idx') ) {
            $this->fields['changed'] = time();
            $statement = db_update($this->table(), $this->fields, "idx=".$this->get('idx'));
            $this->clearLoadCache($this->getCacheCode());
            return $this;
        }
        else {
            if ( ! isset($this->fields['idx']) ) $this->fields['idx'] = NULL;
            if ( ! isset($this->fields['created']) ) $this->fields['created'] = time();
            if ( ! isset($this->fields['changed']) ) $this->fields['changed'] = time();

            $idx = db_insert($this->table(), $this->fields);
            if ( $idx === FALSE ) {
                return FALSE;
            }
            else {
                $this->fields['idx'] = $idx;
                return $this;
            }
        }
    }


    /**
     * @param null $cond
     * @return $this
     * @Attention it returns $this to allow chaining.
     *
     *
     * @Attention
     *
     *      - If the input $cond is empty, then it delete the Entity.
     *
     *      - If the input $cond is NOT empty, then it does Database Query
     *
     *          and returns Database object or result.
     *
     *
     */
    final public function delete($cond=null) {
        if ( $cond ) return Database::load()->delete($this->table(), $cond);
        $idx = $this->get('idx');
        //echo __METHOD__ . " : idx=$idx\n";
        if ( $idx ) {
            db_delete($this->table(), "idx=$idx");
            $this->fields = [];
            //unset(self::$loadCache[$this->cacheCode]);
            $this->clearLoadCache($this->getCacheCode());
        }
        return $this;
    }

    public function __toString() {
        return print_r($this, true);
    }

    public function __get($field) {
        return $this->get($field);
    }
    public function __set($field, $value) {
        return $this->set($field, $value);
    }


    /**
     *
     * Helper methods for Database
     *
     * count()
     * row()
     * rows()
     * insert()
     * update()
     * delete()
     *
     * @param null $cond
     * @param string $field
     *
     * @return Entity
     * @todo test, row(), rows(), count(), result()
     */
    public function row($cond=null, $field='*')
    {
        return Database::load()->row($this->table(), $cond, $field);
    }

    public function rows($cond=null, $field='*')
    {
        return Database::load()->rows($this->table(), $cond, $field);
    }

    public function count($cond=null) {
        return Database::load()->count($this->table(), $cond);
    }

    /**
     *
     * Save cache code
     *
     * @param $code
     */
    private function setCacheCode($code)
    {
        $this->cacheCode = $code;
    }

    private function getCacheCode()
    {
        return $this->cacheCode;
    }

    private function loadData($field, $value)
    {
        $table = $this->table();
        if ( $value === null ) {
            $this->fields = db_row($table, "idx = '$field'");
        }
        else {
            $this->fields = db_row($table, "$field = '$value'");
        }
        return $this->fields;
    }


    /**
     * Sets data into cache variable.
     *
     * @Attention it will index by the cache code. and it will make another index by 'idx' of the item.
     *
     *      This is because
     *
     *          1. when you load item, it makes 'code' based on the field name.
     *          2. when you delete the loaded item, it will remove cache data based on the 'code'
     *          3. The problem begins on the two condition above.
     *              3-1. load data 'A' with code 'abc'
     *              3-2. load data 'A' with code 'def' and delete it.
     *                  3-2-1. load data 'A' is deleted from data base but still alive in cache.
     *              3-3. load data 'A' with code 'abc' and the data is still alive.
     *
     *      For this fact, it maintains another index by 'idx'
     *
     *
     * @param $code
     * @param $data
     *
     *
     */
    private function setCache($code, $data)
    {
        self::$loadCache[$code] = $data;
        self::$loadCacheIdx[$data['idx']][] = $code;
    }


    /**
     *
     *
     * @param $code
     * @return bool
     *
     *      - returns FALSE if there is no cache. You must use '===' to check.
     *
     */
    private function getCache($code)
    {
        if ( isset(self::$loadCache[$code]) ) return self::$loadCache[$code];
        else return FALSE;
    }


    private function cached($code)
    {
        return isset(self::$loadCache[$code]);
    }




    /**
     * Deleting cache on made by load()
     *
     *      - it deletes cache on deleting and updating(save)
     *
     * @param $code
     */
    public function clearLoadCache($code) {
        if ( isset(self::$loadCache[$code]) ) {
            $idx = self::$loadCache[$code]['idx'];
            unset(self::$loadCache[$code]);
            if ( isset(self::$loadCacheIdx[$idx]) ) {
                foreach( self::$loadCacheIdx[$idx] as $code ) {
                    unset(self::$loadCache[$code]);
                }
                unset(self::$loadCacheIdx[$idx]);
            }
        }
    }


}

