<?php
add_css();
add_javascript();
?>
<div id="panel-menu" style="display: none;">
    <ul>
        <li><a href="<?php echo url_forum()?>"><span>Forums</span></a></li>
        <?php if ( login() ) { ?>
            <li><a href="<?php echo url_user_profile()?>"><span>Profile Update</span></a></li>
            <li><a href="<?php echo url_message()?>"><span>Message</span></a></li>
            <li><a href="/user/logout"><span>Logout</span></a></li>
        <?php } else { ?>
            <li><span class="link" route="login">Login</span></li>
            <li><span>Register</span></li>
        <?php } ?>
        <li><span class="link" route="postList" post_id="test">Discussion</span></li>
        <li><span class="link" route="postList" post_id="test">QnA</span></li>
        <li><span>Settings</span></li>
        <?php if ( admin() ) { ?>
            <li><a href="<?php echo url_admin_page(); ?>"><span>Admin Page</span></a></li>
        <?php } ?>
        <li><span class="close-panel">Close</span></li>
    </ul>
</div>
