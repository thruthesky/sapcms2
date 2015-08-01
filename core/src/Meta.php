<?php
namespace sap\src;


class Meta {

    private $table = null;
    public function __construct($table) {
        $this->table = $table . '_meta';
    }

    public function install() {
        Entity::init($this->table)
            ->add('idx_target', 'INT')
            ->add('code', 'varchar', 64)
            ->add('value', 'TEXT')
            ->unique('code')
            ->index('idx_target');
        return $this;
    }
    public function unInstall() {
        Database::load()->dropTable($this->table);
    }

    public function set($code, $value, $target=0)
    {
        $config = Entity::load($this->table, 'code', $code);
        if ( $config ) {
            $config->set('value', $value)
                ->set('idx_target', $target)
                ->save();
        }
        else {
            Entity::create($this->table)
                ->set('code', $code)
                ->set('value', $value)
                ->set('idx_target', $target)
                ->save();
        }
        return $this;
    }
    public function get($code=null, $return_entity=false)
    {
        $entity = Entity::load($this->table, 'code', $code);
        if ( $entity ) {
            if ( $return_entity ) return $entity;
            else return $entity->value;
        }
        else return FALSE;
    }
    public function delete($code) {
        return Entity::load($this->table, 'code', $code)->delete();
    }


    public function group($code)
    {
        return Database::load()->rows($this->table,"code LIKE '$code.%'");
    }
}