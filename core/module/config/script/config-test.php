<?php
config()->createTable();
config()->set('a', 'b');
config()->set('c', 'cherry', 3);
echo config()->get('c') .  PHP_EOL;
echo config('c') .  PHP_EOL;
echo config()->getEntity('c') .  PHP_EOL;

config('d', 'Dove', 4);
echo config('d') . PHP_EOL;

config()->delete('a');
config()->dropTable();
