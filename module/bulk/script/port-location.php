<?php
use sap\src\Database;

$db = Database::load();

$stmt = $db->query("SELECT idx, location FROM " . BULK_DATA . " WHERE location <> ''");
$i = 0;

foreach( $stmt as $row ) {
    if ( ($i++ % 100) == 0 ) {
        echo $i;
        //break;
    }
    $pc = get_province_city($row['location']);
    if ( $pc ) {
        //echo "Location: $row[location]\t=> $pc[province] : $pc[city]\n";
        echo '.';
        $db->update(BULK_DATA, ['province'=>$pc['province'], 'city'=>$pc['city']], "idx=$row[idx]");
        $count = $db->count(BULK_DATA, "province='$pc[province]' AND city='$pc[city]'");
        $db->update(LOCATION, ['count'=>$count], "idx=$pc[idx]");
    }
    else {
        //echo "\t\tFailed Location: $row[location]\n";
        echo 'F';
    }
}
