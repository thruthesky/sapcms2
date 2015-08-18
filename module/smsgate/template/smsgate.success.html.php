<?php
use sap\smsgate\smsgate;
use sap\src\HTML;
$no_item = sysconfig(NO_ITEM);
$no_page = sysconfig(NO_PAGE);

$total_record = $smses = entity(SMS_SUCCESS)->count();

$page_no = page_no();

$from = ($page_no-1) * $no_item;
$smses = entity(SMS_SUCCESS)->rows("ORDER BY idx DESC LIMIT $from, $no_item");




?>
<h1>
    SMSGate Message Success
</h1>
<div>No of SMS in success table : <?php echo $total_record; ?></div>
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
        <th data-priority="4">Tag</th>
        <th>Number</th>
        <th data-priority="1">Message</th>
        <th data-priority="6">Tries</th>
    </tr>
    </thead>
    <tbody>

    <?php
	//di( $_GET );exit;
	
    foreach( $smses as $sms ) {

        echo "<tr>";
        echo "<td><a href='#'>$sms[idx]</a></td>";
        echo "<td>" . date("m/d H:i", $sms['created']) . "</td>";
        echo "<td>$sms[tag]</td>";
        echo "<td>$sms[number]</td>";
        echo "<td>".smsgate::getMessage($sms['idx_message'])."</td>";
        echo "<td>".$sms['no_send_try']."</td>";
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
echo HTML::paging($page_no, $total_record, $no_item, $no_page);

