<?php
add_css();
?>
<div>Current Timezone [ <?php echo date_default_timezone_get()?> ] | <?php echo date("Y-m-d H:i:s",time()) ?></div>

<a class='ui-btn ui-btn-inline<?php if( $variables['page'] == 'queue' ) echo " selected";?>' href='/smsgate/list/queue'>Queue  List</a>
<a class='ui-btn ui-btn-inline<?php if( $variables['page'] == 'success' ) echo " selected";?>' href='/smsgate/list/success'>Success List</a>
<a class='ui-btn ui-btn-inline<?php if( $variables['page'] == 'fail' ) echo " selected";?>' href='/smsgate/list/fail'>Failure List</a>
<a class='ui-btn ui-btn-inline<?php if( $variables['page'] == 'statistics' ) echo " selected";?>' href='/smsgate/statistics'>Statistics</a>
<a class='ui-btn ui-btn-inline<?php if( $variables['page'] == 'send' ) echo " selected";?>' href='/smsgate/send'>Send an SMS</a>