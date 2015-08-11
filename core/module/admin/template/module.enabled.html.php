<table data-role="table" id="table-module-list" data-mode="columntoggle" class="ui-responsive table-stroke">
    <thead>
    <tr>
        <th data-priority="1">Delete</th>
        <th>Module Name</th>
        <th data-priority="2">Description</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach( config()->group('module')->values() as $module ) {
        echo "<tr>";
        echo "<td><a href='/admin/module/disable?name=$module'>Disable</a></td>";
        echo "<td>$module</td>";
        echo "<td>...</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>


