<?php


$rows = user()->rows('limit 10');

echo count($rows);



