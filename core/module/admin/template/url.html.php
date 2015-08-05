<div data-role="header">
    <a href="/admin" class="ui-btn-left ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-home">Admin</a>
    <h1>Admin &gt;&gt; URL Settings</h1>
</div>
<div class="ui-content">

    <h2>
        Url settings
    </h2>
    <form method="post" data-ajax="false">
        <input type="hidden" name="mode" value="submit">
        <?php
        form_input([
            'name' => URL_SITE,
            'label' => 'Input URL of the site :',
            'placeholder' => '',
            'value'=>config(URL_SITE)
        ]);?>

        <input type="submit" value="SUBMIT">
    </form>

</div>
<div data-role="footer"><h1>SAPCMS 2</h1></div>