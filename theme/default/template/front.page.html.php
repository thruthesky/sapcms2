<div data-role="header">
    <h1>Default theme</h1>
</div>
<div class="ui-content">

    <h2>
        Default Theme Front Page
    </h2>

    <?php widget('login-box'); ?>

    Number of users: <?php echo number_of_users() ?>

    <?php echo beautify(systeminfo())?>

</div>
<div data-role="footer"><h1>SAPCMS 2</h1></div>
