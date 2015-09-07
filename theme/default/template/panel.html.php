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
            <li><a href="/user/register"><span>Register</span></a></li>
        <?php } ?>

        <li><a href="/post/list?id=discussion"><span>Discussion</span></a></li>
        <li><a href="/post/list?id=qna"><span>QnA</span></a></li>

        <li><a href="/user/setting"><span>Settings</span></a></li>

        <?php if ( admin() ) { ?>
            <li><a href="<?php echo url_admin_page(); ?>"><span>Admin Page</span></a></li>
        <?php } ?>

        <li><span class="close-panel">Close</span></li>
    </ul>
</div>