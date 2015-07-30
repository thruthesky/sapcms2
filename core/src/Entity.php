<?php
namespace sap\core;

class Entity extends Database {
    private $fields = [];
    private $table = null;
    public function __construct($table) {
        $this->table = $table;
        parent::__construct();
    }
    public static function create($table) {
        $entity = new Entity($table);
        $entity->set('idx', NULL);
        $entity->set('created', time());
        $entity->set('changed', time());
        $entity->set('idx_user', 0);
        $entity->set('ip', ip());
        $entity->set('user_agent', user_agent());
        return $entity;
    }

    public function get($field)
    {
        return isset($this->fields[$field]) ? $this->fields[$field] : null;
    }

    public function set($field, $value)
    {
        $this->fields[$field] = $value;
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


    public static function init($table)
    {
        $db = Database::load();
        $db->dropTable($table);
        $db->createTable($table);
        $db->add('idx_user', 'INT');
        $db->add('ip', 'char', 15);
        $db->add('user_agent', 'varchar', 1024);
        $db->index('idx_user');
        return $db;
    }

    public static function storage($table)
    {
        $db = Database::load();
        $db->table($table);
        return $db;
    }


    public static function load($table=null, $field=null, $value='idx') {
        $entity = new Entity($table);
        if ( empty($field) ) {
            $item = db_row($table, "idx = '$field'");
        }
        else {
            $item = db_row($table, "$field = '$value'");
        }
        if ( $item ) {
            $entity->fields = $item;
            return $entity;
        }
        else return FALSE;
    }

    /**
     * @param null $table - This parameter is only for the compatibility of parent class.
     * @param null $cond - This parameter is only for the compatibility of parent class.
     * @return int
     */
    public function delete($table=null, $cond=null) {
        if ( $table ) {
            return FALSE;
        }
        else {
            if ( $idx = $this->get('idx') ) {
                db_delete($this->table, "idx=$idx");
                $this->fields = [];
                return NULL;
            }
        }
    }
    public function __toString() {
        return print_r($this, true);
    }

}

