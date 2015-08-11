<?php
function hook_admin_menu_smsgate(&$variable=[]){
    echo "
<li data-role='list-divider'>SMSGate Management</li>
<li><a href='/smsgate/list/queue'>Queue  List</a></li>
<li><a href='/smsgate/list/sent'>Sent List</a></li>
";
}