<?php
add_css();
add_javascript();
?>
<div id="panel-menu" style="display: none;">
    <ul>
        <?php if ( login() ) { ?>
            <li><span class="link" route="profile">Profile Update</span></li>
            <li><span class="link" route="message">Message</span></li>
            <li><span class="logout">Logout</span></li>
        <?php } else { ?>
            <li><span class="link" route="login">Login</span></li>
            <li><span class="link" route="register">Register</span></li>
        <?php } ?>
        <li><span class="link" route="postList" post_id="test">Discussion</span></li>
        <li><span class="link" route="postList" post_id="test">QnA</span></li>
        <?php if ( admin() ) { ?>
            <li><span>Admin Page</span></li>
        <?php } ?>
        <li><span class="close-panel">Close</span></li>
    </ul>
</div>
