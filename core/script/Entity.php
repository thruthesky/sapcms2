<?php
use sap\core\Database;
use sap\core\Entity;


$db = Database::load();

$db->dropTable('temp');
$db->createTable('temp');

$db->addColumn('temp', 'name', 'varchar');
$db->addColumn('temp', 'mail', 'varchar');
$db->addColumn('temp', 'birth_year', 'int');

$temp = Entity::create('temp'); // based on database table.
$temp->save();
