<?php
add_css();
?>
<div id="panel-menu">
    <ul>
        <li><a href="<?php echo url_forum()?>">Forums</a></li>
        <?php if ( login() ) { ?>
            <li><a href="<?php echo url_user_profile()?>">Profile Update</a></li>
            <li><a href="<?php echo url_message()?>">Message</a></li>
            <li><a href="/user/logout">Logout</a></li>
        <?php } else { ?>
            <li><a href="/user/register">Register</a></li>
        <?php } ?>
        <li><a href="/user/setting">Settings</a></li>
    </ul>
</div>