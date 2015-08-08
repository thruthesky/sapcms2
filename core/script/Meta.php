<?php
meta('z')->createTable();
meta('z')->set('a', 'b');
meta('z')->set('c', 'cherry', 3);
echo meta('z')->get('c') .  PHP_EOL;
echo meta('z')->getEntity('c') .  PHP_EOL;
meta('z')->delete('a');
meta('z')->dropTable();

