<?php add_css()?>
<?php add_javascript()?>
<div data-role="header">
    <h1>SAPCMS2 Installation</h1>
</div>
<div class="ui-content">
    <h1 class="title">Installation</h1>
<form data-ajax="false" method="post">
    <input type="hidden" name="mode" value="submit">
    <fieldset data-role="controlgroup">
        <legend>Choose Database:</legend>
        <input type="radio" name="database" id="install-database-choce-1" value="sqlite" checked="checked">
        <label for="install-database-choce-1">SQLite</label>
        <input type="radio" name="database" id="install-database-choce-2" value="mysql">
        <label for="install-database-choce-2">MySQL ( Maria DB )</label>
    </fieldset>
    <fieldset class="mysql-information" style="display:none;">
        <legend>MySQL Information</legend>
        <?php form_input([
            'name'=>'database_host',
            'label'=>'Database Host',
            'placeholder'=>''
        ])?>
        <?php form_input([
            'name'=>'database_name',
            'label'=>'Database Name',
            'placeholder'=>''
        ])?>
        <?php form_input([
            'name'=>'database_username',
            'label'=>'Database Username',
            'placeholder'=>''
        ])?>
        <?php form_input([
            'name'=>'database_password',
            'label'=>'Database Password',
            'placeholder'=>''
        ])?>
    </fieldset>

    <fieldset class="admin-information">

        <?php form_input([
            'name'=>'admin_id',
            'label'=>'Site Admin ID',
            'placeholder'=>''
        ])?>
        <?php form_input([
            'name'=>'admin_password',
            'label'=>'Site Admin Password',
            'placeholder'=>''
        ])?>
    </fieldset>
    <input type="submit" value="SUBMIT">
</form>
</div>
<div data-role="footer"><h1>SAPCMS 2</h1></div>