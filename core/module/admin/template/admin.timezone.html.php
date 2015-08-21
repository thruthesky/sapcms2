<h2>
    Timezone settings
</h2>
<?php
echo html_row([
    'caption' => 'Now',
    'text' => date('r')
]);
?>
<?php
echo html_row('Your Selection', config(USER_TIMEZONE_3));
?>
<form method="post">
    <label>Select Your Timezone</label>
    <?php echo html_select_timezone(USER_TIMEZONE_3); ?>
    <input type="submit" value="SUBMIT">
</form>
