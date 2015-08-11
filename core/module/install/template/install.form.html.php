<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="/core/etc/js/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.css" />
</head>
<body>

<div data-role="page">
    <div data-role="header"><h1>SAPCMS 2 Installation</h1></div>
    <div class="ui-content">


<?php add_css()?>
<?php add_javascript()?>


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

<!--[if lt IE 9]>
<script type='text/javascript' src='/core/etc/js/jquery-1.11.3/jquery-1.11.3.min.js'></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type='text/javascript' src='/core/etc/js/jquery-2.1.4/jquery-2.1.4.min.js'></script>
<!--<![endif]-->
<script>
    $( document ).on( "mobileinit", function() {
        //$.mobile.defaultPageTransition = 'slide';
        $.mobile.ajaxEnabled = false;
    });
</script>
<script src="/core/etc/js/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.js"></script>

</body>
</html>