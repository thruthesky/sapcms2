<?php add_javascript('core/module/User/js/user.js'); ?>

<div data-role="header">
    <a href="/admin" class="ui-btn-left ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-home">Admin</a>
    <h1>User Page</h1>
</div>

<div class="ui-content">
    <form action="/user/submit" data-ajax="false">
        <input type="submit" value="submit">
    </form>
</div>

<div data-role="footer"><h1>SAPCMS 2</h1></div>
