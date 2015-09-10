<?php

function hook_admin_menu_category() {
    echo "
      <li data-role='list-divider'>Category</li>
      <li><a href='/admin/category/setting'>Category Settings</a></li>
   ";
}