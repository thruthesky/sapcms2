<?php
use sap\src\Entity;
use sap\src\Meta;
meta('x')->createTable();
meta('x')->set('a', 'b');
meta('x')->set('c', 'cherry', 3);
$m = meta('x')->load('code', 'a');

echo $m->get('value') . PHP_EOL;
echo $m->a . PHP_EOL;
$m->a = 'Black Berry';
echo meta('x')->value('a') . PHP_EOL;
echo meta('x')->getEntity('a')->get('value') .  PHP_EOL;

$x = meta('x')->getEntity('a');

if ( meta('x')->getEntity('a') instanceof Entity ) echo "OK\n";
else echo "ERROR\n";



meta('x')->group('user')->group('jaeho')->set('name', 'JaeHo Song');
meta('x')->group('user')->group('jaeho')->set('age', '41');
meta('x')->group('user')->group('jaeho')->set('gender', 'M');
meta('x')->group('user')->group('jaeho')->set('address', 'Balibago');

echo meta('x')->group('user')->group('jaeho')->value('name') . PHP_EOL;  // 반드시 value 로 값을 가져와야 한다. load() 를 통해서 값을 가져 올 수 없다.
print_r(meta('x')->group('user')->group('jaeho')->gets()); // gets() 를 통해서 그룹 전체 값 읽어 오기

$cars = [
    "car.hyndai.starex" => 2015,
    "car.hyndai.Nubira" => 2014,
    "car.hyndai.Accent" => 2013,
    "car.Samsung.Binara" => 2012,
    "car.Samsung.condole" => 2011,
];
meta('x')->set($cars); // 배열로 그룹 집어 넣기.
print_r(meta('x')->group('car')->group('Samsung')->gets());
meta('x')->group('car')->group_delete(); // 그룹 삭제


function m($code=null, $value=null, $target=0) {
    if ( $value || $target ) {
        return meta('x')->set($code, $value, $target=0);
    }
    else if ( $code ) {
        return meta('x')->value($code);
    }
    else return new Meta('x');
}
m()->set('Jajang', 'China', 1); // 저장
m('Lamon', 'Korea', 2); // 간편 저장
echo m('Lamon') . PHP_EOL; // 간편 읽기

meta('x')->load('code', 'a')->delete(); // 행 삭제
meta('x')->getEntity('c')->delete(); // 행 삭제 다른 방법
meta('x')->dropTable();
