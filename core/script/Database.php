<?php
use sap\src\Database;

$db = Database::load();

$db->dropTable('abc');

$db->createTable('abc');
$db->addColumn('abc', 'a', 'varchar');
$db->addColumn('abc', 'b', 'varchar');
$db->addColumn('abc', 'c', 'varchar');

$db->insert('abc', ['a'=>'A', 'b'=>'B', 'c'=>'C']);
$db->insert('abc', ['a'=>'ABC', 'b'=>'BCD', 'c'=>'CDE']);
$db->insert('abc', ['a'=>'1', 'b'=>'2', 'c'=>'3']);
$db->insert('abc', ['a'=>'apple', 'b'=>'banana', 'c'=>'cherry']);
$db->insert('abc', ['a'=>'apple', 'b'=>'beach', 'c'=>'city']);
$db->insert('abc', ['a'=>'apple', 'b'=>'box', 'c'=>'cake']);


// 두번째 파라메타는 조건을 지정하는데, order by 나 groyp by, limit 도 하나의 조건으로 모두 집어 넣는다.
// 아래에서 Where 다음에는 곧바로 LIMIT 이 들어 갈 수 없으므로 조건이 없으면 1을 기록한다.
print_r($db->row('abc')); // 맨 첫 번째 행 1 개만 끄집어 낸다.
print_r($db->row('abc', "1 LIMIT 0,1")); // 맨 첫번째 행 1 개만 끄집어 낸다.
print_r($db->row('abc', "1 LIMIT 1,1")); // 두번째 행의 열을 꺼집어 낸다.
print_r($db->row('abc', "1 ORDER BY idx ASC LIMIT 2,1")); // 세번째 행의 열을 꺼집어 낸다.
print_r($db->row('abc', null, 'idx, a')); // 조건 없이 첫 행의 idx 와 a 필드만 꺼집어 낸다.
print_r($db->row('abc', "A LIKE 'A%' ORDER BY a DESC LIMIT 1,1", 'idx, a')); // 조건에 맞는 두번째 행의 idx 와 a 필드만 꺼집어 낸다.




print_r($db->rows('abc')); // 모든 행을 다 가져온다.
print_r($db->rows('abc', "1 LIMIT 2,2")); // 세번째 행 부터(세번째 행 포함) 2개의 행을 가져온다.

// 복잡한 쿼리 예: 원하는데로 결과가 나온다.
print_r($db->rows('abc', "a LIKE 'a%' GROUP BY a ORDER BY cnt DESC LIMIT 0,2", 'a,b,c,COUNT(*) as cnt'));

$db->insert('abc', ['a'=>'Airplane', 'b'=>'Boat', 'c'=>'Cruze']);
$db->delete('abc', "b='Boat'");

$db->dropTable('abc');