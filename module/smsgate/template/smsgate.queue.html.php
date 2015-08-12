<?php

use sap\src\HTML;

$no_item = sysconfig(NO_ITEM);
$no_page = sysconfig(NO_PAGE);

$total_record = $smses = entity(QUEUE)->count();

$from = (page_no()-1) * $no_item;
$smses = entity(QUEUE)->rows("limit $from, $no_item");




?>
<h1>
    SMSGate Message Queue
</h1>



<table data-role="table" id="table-module-list" data-mode="columntoggle" class="ui-responsive table-stroke">
    <thead>
    <tr>
        <th data-priority="5">No.</th>
        <th data-priority="3">Created</th>
        <th data-priority="4">Priority</th>
        <th>Number</th>
        <th data-priority="1">Message</th>
        <th data-priority="2">Delete</th>
    </tr>
    </thead>
    <tbody>



    <?php
    foreach( $smses as $sms ) {

        echo "<tr>";
        echo "<td><a href='#'>$sms[idx]</a></td>";
        echo "<td>" . date("m/d H:i", $sms['created']) . "</td>";
        echo "<td>$sms[priority]</td>";
        echo "<td>$sms[number]</td>";
        echo "<td>$sms[message]</td>";
        echo "<td><a href='/smsgate/delete?idx=$sms[idx]'>Delete</a></td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>


    <style>
        nav.navigation-bar a {
            display:inline-block;
            margin:0 1px;
            padding:4px 6px;
            background-color: #d3e8f4;
            border-radius: 2px;
        }
    </style>
<?php
echo HTML::paging(page_no(), $total_record, $no_item, $no_page);