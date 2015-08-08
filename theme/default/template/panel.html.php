<div data-role="panel" id="main-menu-panel" data-position="right" data-display="overlay">
    <!-- panel content goes here -->
    <h1>
        Menu
    </h1>
    <ul data-role="listview">
        <?php if ( login() ) { ?>
            <li><a href="/user/profile" class="ui-btn ui-btn-icon-left ui-icon-user">Profile Update</a></li>
            <li><a href="/message" class="ui-btn ui-btn-icon-left ui-icon-mail">Message</a></li>
            <li><a href="/user/logout" class="ui-btn ui-btn-icon-left ui-icon-action">Logout</a></li>
        <?php } else { ?>
            <li><a href="/user/register" class="ui-btn ui-btn-icon-left ui-icon-user">Register</a></li>
        <?php } ?>

        <li><a href="#main-menu-panel" class="ui-btn ui-btn-icon-left ui-icon-delete">Close</a></li>
    </ul>



</div><!-- /panel -->
