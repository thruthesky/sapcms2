<?php include template('post.admin.menu'); ?>
<?php

$rows = post_config()->rows(null, 'idx,id,name');
if ( $rows ) {

?>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>No. Post</th>
            <th>No. Comment</th>
            <th>List</th>
            <th>EDIT</th>
            <th>Delete</th>
        </tr>
<?php foreach ( $rows as $config ) { ?>
    <tr>
        <td><?php echo $config['id']; ?></td>
        <td><?php echo $config['name']; ?></td>

        <td><?php echo post_data()->count("idx_config=$config[idx] AND idx_parent=0") ?></td>
        <td><?php echo post_data()->count("idx_config=$config[idx] AND idx_parent>0") ?></td>

        <td><a href="/post/list?id=<?php echo $config['id']; ?>">List</a></td>
        <td>Edit</td>
        <td>Delete</td>
    </tr>
<?php
        }
    }
?>
    </table>