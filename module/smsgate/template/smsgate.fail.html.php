<?php
use sap\smsgate\smsgate;
use sap\src\HTML;

$no_item = sysconfig(NO_ITEM);
$no_page = sysconfig(NO_PAGE);

$total_record = $smses = entity(SMS_FAILURE)->count();

$page_no = page_no();

$from = ($page_no-1) * $no_item;
$smses = entity(SMS_FAILURE)->rows("limit $from, $no_item");




?>
<h1>
    SMSGate Message Fail
</h1>
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
        <th>Number</th>
        <th data-priority="1">Message</th>
        <th data-priority="6">Tries</th>
		<th data-priority="7">Next Try on</th>
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
        echo "<td>$sms[number]</td>";
        echo "<td>".smsgate::getMessage($sms['idx_message'])."</td>";
		echo "<td>".$sms['no_send_try']."</td>";        
		if( $sms['stamp_next_send'] ) $next_send = date("Y-m-d H:i",$sms['stamp_next_send']);
		else $next_send = 'none';
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
echo HTML::paging($page_no, $total_record, $no_item, $no_page, null, null, '/smsgate/list/fail');

