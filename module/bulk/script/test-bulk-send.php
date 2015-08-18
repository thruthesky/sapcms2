<?php

//$rows = entity(BULK_DATA)->rows(null, "idx,number");
//echo count($rows);


use sap\src\Database;

$db = Database::load();

//$q = "SELECT data.idx, data.number FROM " . BULK_DATA . " data, " . SMS_SUCCESS . " success";
//$q .= " WHERE data.number!=success.number";

$tag = 'We buy your car';
$tag = 'blue orange';

/*
$q = "SELECT idx, number FROM " . BULK_DATA . " WHERE number NOT IN ( SELECT number FROM " . SMS_SUCCESS . " WHERE tag='$tag')";
$result = $db->query($q);
$rows = $result->fetchAll(PDO::FETCH_ASSOC);
echo "Success Count: " . count($rows) . "\n";

$q = "SELECT idx, number FROM " . BULK_DATA . " WHERE number NOT IN ( SELECT number FROM " . SMS_QUEUE . " WHERE tag='$tag')";
$result = $db->query($q);
$rows2 = $result->fetchAll(PDO::FETCH_ASSOC);
echo "Queue Count: " . count($rows2) . "\n";
*/



$success = entity(SMS_SUCCESS)->rows("tag='$tag'", 'idx, number', \PDO::FETCH_KEY_PAIR);

$data = $db->query("SELECT idx, number FROM " . BULK_DATA)->fetchAll(PDO::FETCH_KEY_PAIR);
$success = $db->query("SELECT idx,number FROM " . SMS_SUCCESS . " WHERE tag='$tag'")->fetchAll(PDO::FETCH_KEY_PAIR);
$queue = $db->query("SELECT idx,number FROM " . SMS_QUEUE . " WHERE tag='$tag'")->fetchAll(PDO::FETCH_KEY_PAIR);
$arr = array_diff($data, $success, $queue);
echo "Array diff Count: " . count($arr) . "\n";



