<a class="ui-btn" href="/post/admin">Post Admin</a>
<?php
$rows = entity(POST_CONFIG)->rows(null, 'id,name');
if ( $rows ) {
    $jqm = jqm()->listview('UL');
    foreach ( $rows as $config ) {
        $jqm->item($config['name']);
    }
    echo $jqm;
}

