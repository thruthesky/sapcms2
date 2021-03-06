<?php
use sap\smsgate\smsgate;
use sap\src\HTML;

add_css();
//add_javascript();

$no_item = sysconfig(NO_ITEM);
$no_page = sysconfig(NO_PAGE);

$total_record = $smses = entity(SMS_QUEUE)->count();

$page_no = page_no();

$from = ($page_no-1) * $no_item;
$smses = entity(SMS_QUEUE)->rows("ORDER BY idx DESC limit $from, $no_item");

?>
<h1>
    SMSGate Message Queue
</h1>


<div>No of SMS in Queue : <?php echo $total_record; ?></div>
<?php include template('smsgate.menu'); ?>

<?php if( !empty( $variables['notice'] ) ){?>
    <div class='notice <?php echo $variables['notice']['type'] ?>'>
        <?php echo $variables['notice']['type'] ?> : <?php echo $variables['notice']['message'] ?>
    </div>
<?php }?>



<table data-role="table" id="table-module-list" data-mode="columntoggle" class="ui-responsive table-stroke">
    <thead>
    <tr>
        <th data-priority="5">No.</th>
        <th data-priority="3">Created</th>
        <th data-priority="4">Priority</th>
        <th data-priority="1">Tag</th>
        <th>Number</th>
        <th data-priority="1">Message</th>
		<th data-priority="6">Tries</th>
		<th data-priority="7">Next Try on</th>
        <th data-priority="2">Delete</th>
    </tr>
    </thead>
    <tbody>

    <?php
	//di( $_GET );exit;
	
    foreach( $smses as $sms ) {

        echo "<tr>";
        echo "<td><a href='#'>$sms[idx]</a></td>";
        echo "<td>" . date("m/d H:i", $sms['created']) . "</td>";
        echo "<td>$sms[priority]</td>";
        echo "<td>$sms[tag]</td>";
        echo "<td>$sms[number]</td>";
        echo "<td>".smsgate::getMessage($sms['idx_message'])."</td>";
		echo "<td>".$sms['no_send_try']."</td>";
		if( $sms['stamp_next_send'] ) $next_send = date("Y-m-d H:i",$sms['stamp_next_send']);
		else $next_send = 'none';
		echo "<td>".$next_send."</td>";
        echo "<td><a href='/smsgate/delete?idx=$sms[idx]&page_no=$page_no'>Delete</a></td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

<?php
echo HTML::paging($page_no, $total_record, $no_item, $no_page, null, null, '/smsgate/list/queue');

