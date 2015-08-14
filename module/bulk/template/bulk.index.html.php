<?php
include template('bulk.menu');
$no_item = sysconfig(NO_ITEM);
$no_page = sysconfig(NO_PAGE);
$total_record = entity(BULK)->count();
$page_no = page_no();
$from = ($page_no-1) * $no_item;
$bulks = entity(BULK)->rows("limit $from, $no_item");
?>
<h1>
    Bulk List
</h1>


<table>

    <?php
    //di( $_GET );exit;

    foreach( $bulks as $bulk ) {

        echo "<tr>";
        echo "<td>$bulk[name]</td>";
        echo "<td>$bulk[message]</td>";
        echo "<td><a href='/smsgate/delete?idx=$bulk[idx]&page_no=$page_no'>SEND</a></td>";
        echo "<td><a href='/smsgate/delete?idx=$bulk[idx]&page_no=$page_no'>Edit</a></td>";
        echo "<td><a href='/smsgate/delete?idx=$bulk[idx]&page_no=$page_no'>Delete</a></td>";
        echo "</tr>";
    }
    ?>
</table>

