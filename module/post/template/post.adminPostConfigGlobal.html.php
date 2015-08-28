<?php


?>

<form method="POST">

    <?php echo html_row( [
        'caption'=>'No. of Items in List Page',
        'text'=> html_input(['name'=>NO_ITEM, 'value'=>sysconfig(NO_ITEM)]),
    ] ); ?>

    <?php echo html_row( [
        'caption'=>'No. of pages in Page Navigator block',
        'text'=> html_input(['name'=>NO_PAGE, 'value'=>sysconfig(NO_PAGE)]),
    ] ); ?>


    <input type="submit" value="UPDATE">
</form>
