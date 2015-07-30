<?php
use sap\core\SQL;

function db_and() {
    return SQL::where();
}

function db_or() {
    return SQL::where('OR');
}
