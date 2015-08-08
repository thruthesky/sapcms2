<?php
config()->createTable();
config()->set('a', 'b');
config()->set('c', 'cherry', 3);
echo config()->get('c') .  PHP_EOL;
echo config()->getEntity('c') .  PHP_EOL;
config()->delete('a');
config()->dropTable();
