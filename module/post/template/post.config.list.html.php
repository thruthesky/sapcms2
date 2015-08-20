<?php include template('post.admin.menu'); ?>
<?php

$rows = post_config()->rows(null, 'id,name');
if ( $rows ) {

?>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>List</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
<?php foreach ( $rows as $config ) { ?>
    <tr>
        <td><?php echo $config['id']; ?></td>
        <td><?php echo $config['name']; ?></td>
        <td><a href="/post/list?id=<?php echo $config['id']; ?>">List</a></td>
        <td>Edit</td>
        <td>Delete</td>
    </tr>
<?php
        }
    }
?>
    </table>