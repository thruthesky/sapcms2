<?php
use sap\src\Database;

$db = Database::load();

$db->dropTable('abc');


$db->dropTable('def');
$db->createTable('def');

$db->createTable('abc');
$db->addColumn('abc', 'a', 'varchar');
$db->addColumn('abc', 'b', 'varchar');
$db->addColumn('abc', 'c', 'varchar');


$db->addColumn('def', 'd', 'varchar');
$db->addColumn('def', 'e', 'varchar');
$db->addColumn('def', 'f', 'varchar');

$db->insert('abc', ['a'=>'Apple', 'b'=>'Banana', 'c'=>'Cherry']);
$db->insert('abc', ['a'=>'Apple', 'b'=>'Banana', 'c'=>'Cherry']);
$db->insert('def', ['d'=>'Delta', 'e'=>'Eskimo', 'f'=>'F-Killer']);
$db->insert('def', ['d'=>'Delta', 'e'=>'Eskimo', 'f'=>'Fly-Killer']);

$result = $db->query("SELECT a,b,c FROM abc UNION SELECT d,e,f FROM def");
print_r($result->fetchAll(PDO::FETCH_ASSOC));