<?php include template('post.admin.menu'); ?>
<?php

$rows = post_config()->rows(null, '*');
if ( $rows ) {

?>

    <table data-role="table" id="table-post-list" data-mode="columntoggle" class="ui-responsive table-stroke">
	<thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th data-priority="1">Description</th>
            <th data-priority="5">Posts</th>
            <th data-priority="6">Comments</th>
            <th data-priority="7">Per Page</th>
            <th data-priority="8">Per Nav</th>
		<!--
            <th data-priority="9">Widget List</th>
            <th data-priority="10">Widget View</th>
            <th data-priority="11">Widget Edit</th>
            <th data-priority="12">Widget Comment</th>
            <th data-priority="13">Widget Search</th>
		-->
            <th data-priority="4">List</th>
            <th data-priority="2">EDIT</th>
            <th data-priority="3">Delete</th>
        </tr>
	</thead>
<?php foreach ( $rows as $config ) {?>
	<tbody>
		<tr>
			<td><?php echo $config['id']; ?></td>
			<td><?php echo $config['name']; ?></td>
			<td><?php echo $config['description']; ?></td>

			<td><?php echo post_data()->count("idx_config=$config[idx] AND idx_parent=0") ?></td>
			<td><?php echo post_data()->count("idx_config=$config[idx] AND idx_parent>0") ?></td>

			<td><?php echo $config['no_item_per_page']; ?></td>
			<td><?php echo $config['no_page_per_nav']; ?></td>
			<?php
			/*
			echo "<td>".$config['widget_list']."</td>";
			echo "<td>".$config['widget_view']."</td>";
			echo "<td>".$config['widget_edit']."</td>";
			echo "<td>".$config['widget_comment']."</td>";
			echo "<td>". $config['widget_search_box']."</td>";
			*/
			?>
			<td><a href="/post/list?id=<?php echo $config['id']; ?>">List</a></td>
			<td><a href="/admin/post/config/edit?id=<?php echo $config['id']; ?>">Edit</a></td>
			<td><a href="/admin/post/config/delete_submit?id=<?php echo $config['id']; ?>">Delete</a></td>			
		</tr>
	</tbody>
<?php
        }
    }
?>
    </table>