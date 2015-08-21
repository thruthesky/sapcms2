

    <h2>
        Default Theme Front Page
    </h2>

    <?php echo date('r'); ?>

    <?php di($_COOKIE); ?>

    <?php widget('login-box'); ?>

    Number of users: <?php echo user_count() ?>

    <?php echo beautify(systeminfo())?>


