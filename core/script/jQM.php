<?php
use sap\src\jQM;
function jqm() {
    return new jQM();
}

$re = jqm()
    ->set('abc', 'def')
    ->set('id', 'name1');

$re = jqm()
    ->listview()
    ->item('abc')
    ->item('def');

echo $re;
