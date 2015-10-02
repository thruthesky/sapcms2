<?php

function hook_admin_menu_post(&$variable=[]){


    echo "
      <li data-role='list-divider'>POST MODULE Management</li>
      <li><a href='/admin/post/config/list'>POST List</a></li>
      <li><a href='/admin/post/config/create'>Create a Post Config</a></li>
   ";
}