<?php
add_css();
?>
<ul id="main-menu">
    <?php if ( admin() ) { ?>
        <li><a href="/admin" class="ui-btn ui-btn-icon-left ui-icon-user">Admin Page</a></li>
    <?php } ?>
    <li><a href="/post">Forums</a></li>
    <?php if ( login() ) { ?>
        <li><a href="/user/profile" class="ui-btn ui-btn-icon-left ui-icon-user">Profile Update</a></li>
        <li><a href="/message" class="ui-btn ui-btn-icon-left ui-icon-mail">Message</a></li>
        <li><a href="/user/logout" class="ui-btn ui-btn-icon-left ui-icon-action">Logout</a></li>
    <?php } else { ?>
        <li><a href="/user/register" class="ui-btn ui-btn-icon-left ui-icon-user">Register</a></li>
    <?php } ?>

    <li><a href="/user/setting" class="ui-btn ui-btn-icon-left ui-icon-gear">Settings</a></li>
</ul>
