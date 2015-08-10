<?php
/*
register_hook('admin_menu', function(&$variable=[]){
    echo "
      <li data-role='list-divider'>User Settings</li>
      <li><a href='/admin/setting/url'>User List</a></li>
      <li><a href='/admin/setting/url'>Block List</a></li>
   ";
});


*/

function hook_admin_menu_user(&$variable=[]){
    echo "
      <li data-role='list-divider'>User Settings</li>
      <li><a href='/admin/setting/url'>User List</a></li>
      <li><a href='/admin/setting/url'>Block List</a></li>
   ";
}