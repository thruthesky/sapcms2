<?php
use sap\src\Database;
$db = Database::load();

$db->dropTable('abc');
$db->dropTable('def');

$db->createTable('abc');
$db->createTable('def');

$db->addColumn('abc', 'A', 'varchar');
$db->addColumn('abc', 'B', 'varchar');
$db->addColumn('abc', 'C', 'varchar');

$db->addColumn('def', 'D', 'varchar');
$db->addColumn('def', 'E', 'varchar');
$db->addColumn('def', 'F', 'varchar');

$db->insert('abc', ['A'=>'Apple', 'B'=>'Banana', 'C'=>'Cherry']);
$db->insert('abc', ['A'=>'1', 'B'=>'2', 'C'=>'3']);
$db->insert('def', ['D'=>'Delta', 'E'=>'Eskimo', 'F'=>'Fly-Killer']);
$db->insert('def', ['D'=>'1', 'E'=>'2', 'F'=>'3']);

print_r($db->query("SELECT a,b,c FROM abc UNION SELECT d,e,f FROM def")->fetchAll(PDO::FETCH_ASSOC));
print_r($db->query("SELECT a,b,c FROM abc UNION ALL SELECT d,e,f FROM def")->fetchAll(PDO::FETCH_ASSOC));
