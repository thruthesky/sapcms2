<?php
function hook_admin_menu_bulk(&$variable=[]){
    echo "
<li data-role='list-divider'>Bulk Management</li>
<li><a href='/bulk'>Bulk List</a></li>
<li><a href='/bulk/create'>Bulk Create</a></li>
";
}