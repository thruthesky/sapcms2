<?php
namespace sap\core;
class User {
    private $fields = [];
    private $attr = ['idx', 'created', 'changed', 'id', 'password', 'name', 'nickname', 'email',
        'birth_year', 'birth_month', 'birth_day', 'gender'];
    public static function create() {

        $user = new User();
        $user->set('idx', NULL);
        $user->set('created', time());
        $user->set('changed', time());
        return $user;
    }
    public static function load($id) {
        $user = new User();
        if ( is_numeric($id) ) $row = db_row('user', 'idx', $id);
        else  $row = db_row('user', 'id', $id);
        $user->sets($row);
        return $user;
    }

    public static function createTable()
    {
        $db = Database::load();

        $db->dropTable('user');
        $db->createTable('user');
        $db->addColumn('user', 'id', 'varchar', 32);
        $db->addColumn('user', 'password', 'varchar', 32);
        $db->addColumn('user', 'name', 'varchar', 32);
        $db->addColumn('user', 'nickname', 'varchar', 32);
        $db->addColumn('user', 'email', 'varchar', 64);
        $db->addColumn('user', 'birth_year', 'int');
        $db->addColumn('user', 'birth_month', 'int');
        $db->addColumn('user', 'day', 'int');
        $db->addColumn('user', 'gender', 'char', 1);

        $db->addUniqueKey('user', 'id');
        $db->addIndex('user', 'name');
        $db->addIndex('user', 'nickname');
        $db->addIndex('user', 'email');
        $db->addIndex('user', 'birth_year');

        $db->dropTable('user_meta');
        $db->createTable('user_meta');
        $db->addColumn('user_meta', 'idx_user', 'INT UNSIGNED');
        $db->addColumn('user_meta', 'code', 'varchar', 32);
        $db->addColumn('user_meta', 'value', 'TEXT');
        $db->addUniqueKey('user_meta', 'code');

        return $db;
    }

    public function set($field, $value)
    {
        $this->fields[$field] = $value;
        return $this;
    }

    public function save()
    {
        $idx = db_insert('user', ['id'=>$this->fields['id']]);


/*

        $a = db_cond('idx', 3, '>=');
        $b = db_or(
            db_cond('idx', 1, '='),
            db_cond('idx', 2, '='),
            db_cond('idx', 4)
        );
        $c = db_cond('name', 'abc%', 'like');
        db_and( $a, $b, $c );
        echo db_cond();

        db_update('user', ['email'=>$this->fields['email']], ['idx'=>$idx]);
        */

        print_r($this->fields);
    }

    private function sets($record)
    {
        $this->fields = $record;
    }

    public function getRecord() {
        return $this->fields;
    }
}