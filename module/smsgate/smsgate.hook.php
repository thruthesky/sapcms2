<?php
function hook_admin_menu_smsgate(&$variable=[]){
    echo "
<li data-role='list-divider'>SMSGate Management</li>
<li><a href='/smsgate/list/queue'>Queue  List</a></li>
<li><a href='/smsgate/list/success'>Success List</a></li>
<li><a href='/smsgate/list/fail'>Failure List</a></li>
<li><a href='/smsgate/list/blocked'>Blocked List</a></li>
<li><a href='/smsgate/statistics'>Statistics</a></li>
<li><a href='/smsgate/send'>Send an SMS</a></li>
<li><a href='/smsgate/block'>Block numbers</a></li>
";
}