<?php
$n = 5000;
$i = 0;
while( true ) {
    $count = entity('stress')->count();
    $rand = rand(0, $count -1);
    $entity = entity('stress')->load($rand);
    if ( empty($entity) ) continue;
    $entity
        ->set('name', "updated" . $entity->get('name'))
        ->save();
    $entity->delete();
    echo ".";
    $i ++;
    if ( $i >= $n ) break;
    if ( $i % 100 == 0 ) echo $i;
}
