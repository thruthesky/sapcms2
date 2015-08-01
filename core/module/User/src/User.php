<?php
namespace sap\core;
use sap\src\Entity;

class User extends Entity {
    private $fields = [];


    public static function create($table='user')
    {
        return parent::create($table);
    }
    public static function load($field=null, $value='idx', $table='user')
    {
        return parent::load($table, $field, $value);
    }

    public static function initStorage()
    {
        parent::init('user')
            ->add('id', 'varchar', 32)
            ->add('password', 'char', 32)
            ->add('domain', 'varchar', 64)
            ->add('name', 'varchar', 32)
            ->add('nickname', 'varchar', 32)
            ->add('mail', 'varchar', 64)
            ->add('birth_year', 'int')
            ->add('birth_month', 'int')
            ->add('birth_day', 'int')
            ->add('landline', 'varchar', 32)
            ->add('mobile', 'varchar', 32)
            ->add('address', 'varchar', 255)
            ->add('country', 'varchar', 255)
            ->add('province', 'varchar', 255)
            ->add('city', 'varchar', 255)
            ->add('school', 'varchar', 128)
            ->add('work', 'varchar', 128)
            ->unique('id')
            ->index('domain')
            ->index('name')
            ->index('nickname')
            ->index('mail')
            ->index('birth_year,birth_month,birth_day');
    }



}