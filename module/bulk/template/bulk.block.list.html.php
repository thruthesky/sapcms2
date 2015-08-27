<?php
use sap\bulk\bulk;
use sap\src\HTML;

add_css();
//add_javascript();

$no_item = sysconfig(NO_ITEM);
$no_page = sysconfig(NO_PAGE);

$total_record = $smses = entity(BULK_BLOCKED)->count();

$page_no = page_no();

$from = ($page_no-1) * $no_item;
$smses = entity(BULK_BLOCKED)->rows("ORDER BY idx DESC limit $from, $no_item");

?>
<h1>
    SMSGate Message Blocked
</h1>


<div>No of SMS in Queue : <?php echo $total_record; ?></div>
<?php include template('bulk.block.menu'); ?>

<?php if( !empty( $variables['notice'] ) ){?>
    <div class='notice <?php echo $variables['notice']['type'] ?>'>
        <?php echo $variables['notice']['type'] ?> : <?php echo $variables['notice']['message'] ?>
    </div>
<?php }?>



<table data-role="table" id="table-module-list" data-mode="columntoggle" class="ui-responsive table-stroke">
    <thead>
    <tr>
        <th data-priority="4">No.</th>
        <th data-priority="3">Created</th>
        <th>Number</th>
        <th data-priority="2">Reason</th>
        <th data-priority="1">Delete</th>
    </tr>
    </thead>
    <tbody>

    <?php
	//di( $_GET );exit;
	
    foreach( $smses as $sms ) {

        echo "<tr>";
        echo "<td><a href='#'>$sms[idx]</a></td>";
        echo "<td>" . date("m/d H:i", $sms['created']) . "</td>";
        echo "<td>$sms[number]</td>";
		echo "<td>$sms[reason]</td>";
        echo "<td><a href='/bulk/block/delete?idx=$sms[idx]&page_no=$page_no'>Delete</a></td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

<?php
echo HTML::paging($page_no, $total_record, $no_item, $no_page, null, null, '/bulk/block/list');

