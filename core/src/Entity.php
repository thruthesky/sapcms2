<?php
namespace sap\core;

class Entity {
    private $fields = [];
    private $table = null;
    public static function create($table) {
        $entity = new Entity();
        $entity->table = $table;
        $entity->set('idx', NULL);
        $entity->set('created', time());
        $entity->set('changed', time());
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

    public function save()
    {
        if ( $this->get('idx') ) {

        }
        else {

        }
        print_r($this->fields);
    }
}

