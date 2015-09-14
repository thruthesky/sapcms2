<?php
add_css('category.default.css');

if( !empty( $categories ) ){
?>
	<table data-role="table" id="table-module-list" data-mode="columntoggle" class="ui-responsive table-stroke table-list default">
		<thead>
		<tr>			
			<th>Name</th>			    
			<th data-priority="3">IDX</th>   
			<th data-priority="4">Parent</th>    
			<th data-priority="5">Depth</th>        					
			<th data-priority="6">Children</th>
			<th data-priority="1">Action</th>        
		</tr>
		</thead>
		<tbody>
	<?php
		foreach( $categories as $c ) {
			if( !empty( $c['depth'] ) )	{
				$depth = $c['depth'];				
				$auto_margin = " style='margin-left:". ( 20 * $depth ) ."px'";
			}
			else {
				$auto_margin = null;
				$depth = 0;
			}
			
			
			echo "<tr>";			
			echo "<td><div$auto_margin>$c[name]</div></td>";
			echo "<td>$c[idx]</td>";			
			echo "<td>$c[idx_parent]</td>"; 
			echo "<td>$depth</td>"; 						 				 
			echo "<td>$c[no_of_children]</td>";        
			echo "
					<td idx='$c[idx]' description='$c[name]'>
						<a class='admin-button default' href='/admin/category/setting?idx=$c[idx]'>Edit</a>";
			?>
			<a class='admin-button default' onclick="return confirmCategoryDelete('<?php echo $c['name']; ?>')" href='/admin/category/setting/delete?idx=<?php echo $c['idx']; ?>'>Delete</a> 
			<?php
			echo "<span class='admin-button default add-child'>Add Child</span>
					</td>";
			echo "</tr>";
		}
	 ?>
		</tbody>
	</table>
<?php
}
?>