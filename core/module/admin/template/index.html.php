<div data-role="header">
    <a href="/admin" class="ui-btn-left ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-home">Admin</a>
    <h1>Admin</h1>
    <a href="/" class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-home">Site</a>
</div>
<div class="ui-content">
    <ul data-role="listview" data-inset="true" data-divider-theme="a">
        <?php call_hooks('admin_menu'); ?>
    </ul>
</div>
<div data-role="footer"><h1>SAPCMS 2</h1></div>