<div>Current Timezone [ <?php echo date_default_timezone_get()?> ] | <?php echo date("Y-m-d H:i:s",time()) ?></div>

<a class='ui-btn ui-btn-inline' href='/smsgate/list/queue'>Queue  List</a>
<a class='ui-btn ui-btn-inline' href='/smsgate/list/success'>Success List</a>
<a class='ui-btn ui-btn-inline' href='/smsgate/list/fail'>Failure List</a>
<a class='ui-btn ui-btn-inline' href='/smsgate/statistics'>Statistics</a>
<a class='ui-btn ui-btn-inline' href='/smsgate/send'>Send an SMS</a>