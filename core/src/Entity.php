<?php
namespace sap\src;


class Entity {
    private static $loadCache = [];
    private $fields = [];
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
        dog(__METHOD__);
        $table = $this->table();
        $code = "$table:$field:$value";
        dog( __METHOD__  . ' : ' . $code);

        if ( isset(self::$loadCache[$code]) ) {
            //echo("load is cached: $code\n");
            $this->cacheCode = $code;
            $this->fields = self::$loadCache[$code];

            if ( empty($this->fields) ) {
                //dog("fields is empty");
                return FALSE;
            }
            else {
                return $this;
            }
        }
        //echo("load is NOT cached:code\n");


        /**
         * Remember cacheCode to delete from memory when it is deleted
         */
        $this->cacheCode = $code;
        if ( $value === null ) {
            $this->fields = db_row($table, "idx = '$field'");
        }
        else {
            $this->fields = db_row($table, "$field = '$value'");
        }
        if ( $this->fields ) {
            self::$loadCache[$code] = $this->fields;
        }
        hook('entity_load', $this);
        if ( empty(self::$loadCache[$code]) ) return FALSE;
        else return $this;
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
        else return $this->fields;
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
    final public function set($field, $value=null)
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
    final public function save()
    {
        if ( $this->get('idx') ) {
            $this->fields['changed'] = time();
            $statement = db_update($this->table(), $this->fields, "idx=".$this->get('idx'));
            return $this;
        }
        else {

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
            /**
             * Deleting cache on made by load()
             */
            unset(self::$loadCache[$this->cacheCode]);
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


}

