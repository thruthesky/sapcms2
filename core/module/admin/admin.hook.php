<?php
/*
register_hook('admin_menu', function(&$variable=[]){
   echo "
      <li data-role='list-divider'>System Information &amp; Settings</li>
      <li><a href='/admin/setting/url'>URL Settings</a></li>
      <li><a href='#'>Log Settings</a></li>
      <li><a href='/admin/database/information'>Database information</a></li>
      <li data-role='list-divider'>Permission Settings</li>
      <li><a href='/admin/setting/url'>User Permission</a></li>
   ";
});
*/

function hook_admin_menu_admin(&$variable=[]){
    echo "
      <li data-role='list-divider'>System Information &amp; Settings</li>
      <li><a href='/admin/setting/url'>URL Settings</a></li>
      <li><a href='#'>Log Settings</a></li>
      <li><a href='/admin/database/information'>Database information</a></li>
      <li data-role='list-divider'>Permission Settings</li>
      <li><a href='#'>User Permission</a></li>

      <li data-role='list-divider'>Module Management</li>
      <li><a href='/admin/module/all'>All Module List</a></li>
      <li><a href='/admin/module/enabled'>Installed Module List</a></li>

   ";
}
