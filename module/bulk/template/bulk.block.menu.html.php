<?php
add_css();
?>
<div>Current Timezone [ <?php echo date_default_timezone_get()?> ] | <?php echo date("Y-m-d H:i:s",time()) ?></div>

<a class='ui-btn ui-btn-inline<?php if( $variables['page'] == 'block' ) echo " selected";?>' href='/bulk/block'>Block number/s</a>
<a class='ui-btn ui-btn-inline<?php if( $variables['page'] == 'block_list' ) echo " selected";?>' href='/bulk/block/list'>Block List</a>