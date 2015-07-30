<?php
namespace sap\core;
class User {
    private $fields = [];


    public static function create()
    {
        return Entity::create('user');
    }
    public static function load($field=null, $value='idx')
    {
        return Entity::load('user', $field, $value);
    }



    public static function initStorage()
    {
        Entity::init('user')
            ->add('id', 'varchar', 32)
            ->add('password', 'char', 32)
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
            ->index('name')
            ->index('nickname')
            ->index('mail')
            ->index('birth_year,birth_month,birth_day');
    }



}