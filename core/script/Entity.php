<?php
use sap\core\Database;
use sap\core\Entity;
$db = Database::load();

// 아래의 코드는 Entity 를 초기화 하는 것으로
// 실제로 데이터베이스 테이블을 생성하고
// 필드를 추하며,
// 인덱스를 생성한다.
Entity::init('temp')
    ->add('name', 'varchar')
    ->add('mail', 'varchar')
    ->add('birth_year', 'int')
    ->add('birth_month', 'int')
    ->add('birth_day', 'int')
    ->unique('mail')
    ->index('name')
    ->index('birth_year,birth_month,birth_day');

// 초기화 한 Entity 테이블을 수정(필드 추가 등)하는 방법
Entity::storage('temp')
    ->add('gender', 'char', 1)
    ->index('gender');


Database::load()->table('temp')->add('address', 'varchar', 255);


$temp = Entity::create('temp')
    ->set('name', 'JaeHo Song')
    ->set('mail', 'thruthesky@gmail.com')
    ->set('birth_year', 1973)
    ->set('birth_month', 10)
    ->set('birth_day', 16)
    ->save();

// Entity 를 출력 할 수 있다.
echo Entity::load('temp', $temp->get('idx'));

$temp = Entity::create('temp')
    ->set('name', 'Jae')
    ->set('mail', 'thruthesky@naver.com')
    ->set('birth_year', 1993)
    ->set('birth_month', 10)
    ->set('birth_day', 16)
    ->save();

// 아래의 코드는 Entity 를 로드하고 수정하는 방법이다.
$temp = Entity::load('temp', $temp->get('name'), 'name')
    ->set('name', 'My Name: Jae')
    ->save();
echo $temp;

// 아래의 코드는 해당 Entity 를 삭제하는 방법이다.
$temp->delete();
// 삭제를 하면,
echo $temp;


