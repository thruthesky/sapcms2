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

    $count_entire_number = entity(BULK_DATA)->count();
    $locations = get_location_province();
    $select_location = "<select name='location' data-inline='true'>";
    $select_location .= "<option value=''>Entire Location ($count_entire_number)</option>";
    foreach( $locations as $location ) {
        $select_location .= "<option value='$location[province]'>$location[province] ($location[cnt])</option>";
    }
    $select_location .= "</select>";

    $categories = get_bulk_category();

    $select_category = "<select name='category' data-inline='true'>";
    $select_category .= "<option value=''>Entire Category ($count_entire_number)</option>";
    foreach( $categories as $category ) {
        if ( empty($category['category']) ) $category['category'] = 'No category';
        $select_category .= "<option value='$category[category]'>$category[category] ($category[cnt])</option>";
    }
    $select_category .= "</select>";

    $select_last_send = "<select name='days' data-inline='true'>";
    $select_last_send .= "<option value='7'>7 Day</option>";
    $select_last_send .= "<option value=''>Last Send</option>";
    $select_last_send .= "<option value='1'>1 Day</option>";
    $select_last_send .= "<option value='2'>2 Day</option>";
    $select_last_send .= "<option value='3'>3 Day</option>";
    $select_last_send .= "<option value='5'>5 Day</option>";
    $select_last_send .= "<option value='7'>7 Day</option>";
    $select_last_send .= "<option value='10'>10 Day</option>";
    $select_last_send .= "<option value='15'>15 Day</option>";
    $select_last_send .= "<option value='20'>20 Day</option>";
    $select_last_send .= "<option value='30'>30 Day</option>";
    $select_last_send .= "<option value='50'>50 Day</option>";
    $select_last_send .= "<option value='100'>100 Day</option>";
    $select_last_send .= "</select>";


    foreach( $bulks as $bulk ) {
        $no_sent = entity(SMS_SUCCESS)->result('COUNT(*)', "tag='$bulk[name]'");
        echo "<tr>";
        echo "<td><b>$bulk[name]</b></td>";
        echo "<td>$bulk[message]</td>";
        echo "<td><a href='/smsgate/delete?idx=$bulk[idx]&page_no=$page_no'>Edit</a></td>";
        echo "<td><a href='/smsgate/delete?idx=$bulk[idx]&page_no=$page_no'>Delete</a></td>";
        echo "</tr>";
        echo "<tr>";
        echo "
            <td colspan='4'>
            <form action='/bulk/send'>
            <input type='hidden' name='idx' value='$bulk[idx]'>
            $select_location
            $select_category
            $select_last_send
                <input type='submit' value='SEND' data-inline='true'>

                ( No. of SENT: $no_sent )
                </form>
            </td>";
        echo "</tr>";
    }
    ?>
</table>


<ul>
    <li>
        Location
        - Sends SMS BULK TXT only to those people of this location.
    </li>
    <li>
        Category
        - Sends SMS BULK TXT only to those people of this category.
    </li>
    <li>
        Last send
        - Sends SMS BULK TXT only to those people who did not get SMS within the day.
    </li>
    <li>How to combine
        <ul>
            <li>
                Last send(days) is important not to send over again on same number.<br>
                For instance,<br>
                You sent a message with 'phone' bulk on a number yesterday and you send another bulk 'car' on the same number today.<br>
                The person may get irritated.<br>
                If you set Last send(days) to 3 days, then the person will not get SMS again even though the 'bulk' has changed.<br>
                After three days, if you send that bulk again or with a new bulk and set the 'last send(days)' to 3 days, then the person will get a TEXT again.
            </li>
        </ul>
    </li>
    <li>
        Note: If you combine the options, the number of SMS TXT may differ from the number appears beside the option.
    </li>
</ul>
