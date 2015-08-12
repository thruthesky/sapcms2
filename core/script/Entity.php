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

echo entity('temp')->load('name','JaeHo Song')->get('name') . PHP_EOL;


$temp = entity('temp')
    ->set('name', 'Your-name')
    ->save();

echo entity('temp')->load($temp->get('idx'))->get('name') . PHP_EOL;


$temp->delete();
entity('temp')->dropTable();


entity('def')->createTable();
entity('def')->loadTable()
    ->add('name', 'varchar');
entity('def')->set('name', 'jaeho')->save();
entity('def')->load('name', 'jaeho')->delete();
entity('def')->dropTable();


$table = 'entity_test_2';
entity($table)->createTable()
    ->add('Fruit', 'varchar')
    ->add('Car', 'varchar')
    ->add('Animal', 'varchar');

entity($table)
    ->set('Fruit', 'Apple')
    ->set('Car', 'BMW')
    ->set('Animal', 'Cat')
    ->save();

echo entity($table)->count() . PHP_EOL;
if ( 'BMW' == entity($table)->load('Fruit', 'Apple')->get('Car') ) echo "OK\n";
else echo "error\n";

entity($table)
    ->set(['Fruit'=>'Banana', 'Car'=>'Starex', 'Animal'=>'Dog'])
    ->save();

/**
 * The code below;
 *
 * 1. load a data with Fruit=Banana
 * 2. load same data with Animal=Dog AND delete
 * 3. load the same data with Fruit=Banana and the data is no longer exist.
 *
 *
 */
if (entity($table)->load('Fruit', 'Banana')->get('Animal') == 'Dog' ) echo "OK\n";
else echo "ERROR\n";
entity($table)->load('Animal', 'Dog')->delete();
if ( entity($table)->load('Fruit', 'Banana') == false ) echo "OK" . PHP_EOL;
else echo "Fruit Banana => ERROR\n";

if ( entity($table)->load('Car', 'BMW')->get('Fruit') == 'Apple' ) echo "OK\n";
else echo "ERROR\n";

Database::load()->dropTable($table);
