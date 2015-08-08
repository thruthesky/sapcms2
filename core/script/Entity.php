<?php

use sap\src\Database;
use sap\src\Entity;

$db = Database::load();

entity('temp')->createTable()
    ->add('name', 'varchar')
    ->add('mail', 'varchar')
    ->add('birth_year', 'int')
    ->add('birth_month', 'int')
    ->add('birth_day', 'int')
    ->unique('mail')
    ->index('name')
    ->index('birth_year,birth_month,birth_day');


entity('temp')->loadTable()
    ->add('gender', 'char', 1)
    ->index('gender');

Database::load()->table('temp')->add('address', 'varchar', 255);


$temp = entity('temp')
    ->create(['created'=>1, 'changed'=>2])
    ->set('name', 'JaeHo Song')
    ->save();


$temp = entity('temp')
    ->set('name', 'Your-name')
    ->save();

echo entity('temp')->load($temp->get('idx'));
echo user(1);
echo user('id', 'admin');


$temp->delete();
entity('temp')->dropTable();


entity('def')->createTable();
entity('def')->loadTable()
    ->add('name', 'varchar');
entity('def')->set('name', 'jaeho')->save();
entity('def')->load('name', 'jaeho')->delete();
entity('def')->dropTable();

