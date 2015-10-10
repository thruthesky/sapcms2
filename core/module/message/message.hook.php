<?php

function hook_admin_menu_message(&$variable=[]){
    echo "
      <li data-role='list-divider'>Message Module Management</li>
      <li><a href='/message/create'>Create a Message</a></li>
   ";
}