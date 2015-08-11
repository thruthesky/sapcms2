<?php

?>
<table data-role="table" id="table-module-list" data-mode="columntoggle" class="ui-responsive table-stroke">
    <thead>
    <tr>
        <th data-priority="1">Enable</th>
        <th>Module Name</th>
        <th data-priority="2">Description</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $enabled = array_values( config()->group('module')->gets() );
    foreach( glob(PATH_MODULE . '/*', GLOB_ONLYDIR) as $path ) {
        $module = get_module_from_path($path);
        echo "<tr>";
        if ( in_array($module, $enabled) ) {
            echo "<td>Enabled</td>";
        }
        else echo "<td><a href='/admin/module/enable?name=$module'>Enable</a></td>";
        echo "<td>$module</td>";
        echo "<td>...</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
