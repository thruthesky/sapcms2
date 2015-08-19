<form action="/post/config/create_submit">
    Post configuration ID :
    <input type="text" name="id" value="">

    Post configuration name :
    <input type="text" name="name" value="">

    <input type="submit" value="CREATE A POST CONFIG">
</form>

<?php

$rows = post_config()->rows(null, 'id,name');
if ( $rows ) {
    $jqm = jqm()->listview('UL');
    foreach ( $rows as $config ) {
        $jqm->item($config['name']);
    }
    echo $jqm;
}

?>
