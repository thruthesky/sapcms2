<?php
use sap\src\Database;
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
$time_start = microtime_float();

$table = 'stress_database';
entity($table)->createTable()
    ->add('name', 'varchar')
    ->add('age', 'smallint')
    ->add('gender', 'char')
    ->add('title', 'varchar')
    ->add('content', 'text')
    ->add('no', "int unsigned default '0'")
    ->add('ip', 'char', 15)
    ->add('referrer', 'varchar', 1024)
    ->add('hash', 'char', 32)
    ->add('stamp', "int unsigned default '0'")
    ->unique('hash')
    ->index('name,age,gender')
    ->index('title')
    ->index('ip');

$up = [];
entity()->beginTransaction();
for($i=0; $i<1999; $i++) {
    $entity = entity($table)->create()
        ->set('name', "$i")
        ->set('age', $i)
        ->set('gender', 'M')
        ->set('title', "Title $i")
        ->set('content', "Content $i - This is the content. Number is $i. I remember new thing about Linage2")
        ->set('ip', '192.168.0.111')
        ->set('referrer', 'http://abc.com/~abc/after-dinner.html')
        ->set('hash', uniqid('abc'))
        ->set('stamp', time())
        ->save();
    //$entity->set('age', $entity->get('age') + 1)->save();
    $up[ $entity->idx ] = $entity->age;
    echo ".";
}
$count = count($up);
echo "Count: $count";
$q = null;
foreach( $up as $idx => $age ) {
    $n = $age + 1;
    $q .= "UPDATE $table SET age=$n WHERE idx=$idx;";
}
system_log($q);
Database::load()->exec($q);
entity()->commit();

echo PHP_EOL;
echo "name 1 : " . entity($table)->load('name', '1')->get('age') . PHP_EOL;



$time_end = microtime_float();
$time = round($time_end - $time_start, 3);

echo "\nIt took $time seconds\n";

entity($table)->dropTable();