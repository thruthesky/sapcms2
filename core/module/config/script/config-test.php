<?php
config()->set('a', 'b');
config()->set('c', 'cherry', 3);
echo config()->load('code', 'c')->get('c') .  PHP_EOL;
echo config('c') .  PHP_EOL;
echo config()->getEntity('c') .  PHP_EOL;

config('one', 'One banana 6', 1); // 이렇게 값을 저장하고,
echo config('one') . PHP_EOL; // 이렇게 값을 읽을 수 있다.


config()->getEntity('a')->delete();


