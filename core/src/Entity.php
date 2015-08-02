<?php
namespace sap\src;

class Entity {
    private $fields = [];
    private $table = null;
    public function __construct($table) {
        $this->table = $table;

    }

    public static function create($table) {
        $entity = new Entity($table);
        $entity->set('idx', NULL);
        $entity->set('created', time());
        $entity->set('changed', time());

        // $entity->set('idx_target', 0);

        call_hooks('entity_create', $entity);

        return $entity;
    }

    public static function load($table=null, $field=null, $value=null) {
        $entity = new Entity($table);
        if ( empty($value) ) {
            $item = db_row($table, "idx = '$field'");
        }
        else {
            $item = db_row($table, "$field = '$value'");
        }
        if ( $item ) {
            $entity->fields = $item;
            call_hooks('entity_load', $entity);
            return $entity;
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
    public function get($field=null)
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
    public function set($field, $value=null)
    {
        if ( is_array($field) ) {
            $this->fields = array_merge($this->fields, $field);
        }
        else $this->fields[$field] = $value;
        return $this;
    }


    /**
     * @return $this
     *
     */
    public function save()
    {
        if ( $this->get('idx') ) {
            $this->fields['changed'] = time();
            $statement = db_update($this->table, $this->fields, "idx=".$this->get('idx'));
            return $this;
        }
        else {
            $idx = db_insert($this->table, $this->fields);
            $this->fields['idx'] = $idx;
            return $this;
        }
    }


    /**
     * @param null $table
     * @return bool|null|Database
     *
     *
     * @see buildguide
     */
    public static function init($table=null)
    {
        $db = Database::load();
        $db->dropTable($table);
        $db->createTable($table);
        $db->add('created', 'INT UNSIGNED DEFAULT 0');
        $db->add('changed', 'INT UNSIGNED DEFAULT 0');
        $db->addIndex($table, 'created');
        $db->addIndex($table, 'changed');

        //$db->add('idx_target', 'INT');
        //$db->add('ip', 'char', 15);
        //$db->add('user_agent', 'varchar', 1024);
        //$db->index('idx_target');
        return $db;
    }

    public static function storage($table)
    {
        $db = Database::load();
        $db->table($table);
        return $db;
    }


    public function delete() {
        if ( $idx = $this->get('idx') ) {
            db_delete($this->table, "idx=$idx");
            $this->fields = [];
            return NULL;
        }
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
     * @param $table_name
     * @return Entity
     */
    public static function query($table_name)
    {
        return new Entity($table_name);
    }
    public function count($cond=null) {
        return Database::load()->count($this->table, $cond);
    }



}

