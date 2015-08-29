<p>
    No of Post Config : <?php echo post_config()->count(); ?>
</p>
<?php

$configs = post_config()->rows();
if ( $configs ) {
    echo "<table>";
    echo "<tr>

    <th>ID</th>
    <th>Name</th>
    <th>Description</th>

</tr>";
    foreach( $configs as $config ) {
        echo "
        <tr>
        <td>$config[id]</td>
        <td>$config[name]</td>
        <td>$config[description]</td>
        <td><a href='/post/list?id=$config[id]'>LIST</a></td>
        </tr>
        ";
    }
    echo "</table>";
}

