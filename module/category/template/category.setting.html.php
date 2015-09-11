<script src='/module/appdev/js/jquery/jquery-2.1.4.min.js'></script>
<?
add_css();
add_javascript("category.js");
use sap\src\HTML;
use sap\category\Category;

extract( $variables );
$name = "";
$description = "";
$idx_parent = "";

?>
<div class='category-setting'>
	<h1>Create Root Category</h1>
	<form action="/admin/category/setting/submit" method="post">

		<?php
			if( !empty( $data['category'] ) ) {
				$category = $data['category']->fields;
				echo html_hidden([ "name" => "idx","value"=>$category['idx'] ]);
				echo html_hidden([ "name" => "name","value"=>$category['code'] ]);
				$description = $category['value'];
				
				echo "Name<div>$category[code]</div>";
			}
			else{
				echo html_row([
						'caption' => 'Name',
						'text' => html_input(["name" => "name", 'value'=>$name]),
					]);		
			}
			echo html_row([
					'caption' => 'Description',
					'text' => html_input(["name" => "description", 'value'=>$description]),
				]);		
		?>
		<input type="submit">

	</form>
	<table data-role="table" id="table-module-list" data-mode="columntoggle" class="ui-responsive table-stroke table-list default">
		<thead>
		<tr>
			<th data-priority="3">IDX</th>   
			<th>Name</th>			    
			<th data-priority="4">Parent</th>    
			<th data-priority="5">Depth</th>        			
			<th data-priority="2">Description</th>			
			<th data-priority="6">Children</th>
			<th data-priority="1">Action</th>        
		</tr>
		</thead>
		<tbody>
	<?php
		$categories = [];
		
		$root_categories = category()->rows("idx_target = 0");		
		foreach( $root_categories as $c ){
			$root = [];			
			$children = Category::loadAllChildren( $c['idx'] );
			$root = $c;
			$root['no_of_children'] = count( $children );
			$categories[] = $root;
			foreach( $children as $child ) {
				$categories[] = $child;
			}
		}
	
		foreach( $categories as $c ) {
			if( !empty( $c['depth'] ) )	{
				$depth = $c['depth'];
				$auto_margin = " style='margin-left:". ( 5 * $depth ) ."px'";
			}
			else {
				$auto_margin = null;
				$depth = 0;
			}
			
			
			echo "<tr>";			
			echo "<td><div$auto_margin>$c[idx]</div></td>";
			echo "<td>$c[code]</td>";
			echo "<td>$c[idx_target]</td>"; 
			echo "<td>$depth</td>"; 						 
			echo "<td>$c[value]</td>";    				 
			echo "<td>$c[no_of_children]</td>";        
			echo "
					<td idx='$c[idx]' description='$c[value]'>
						<a class='admin-button default' href='/admin/category/setting?idx=$c[idx]'>Edit</a> 
						<a class='admin-button default' href='/admin/category/setting/submit?idx=$c[idx]&action=delete'>Delete</a> 
						<span class='admin-button default add-child'>Add Child</span>
					</td>";
			echo "</tr>";
		}
	 ?>
		</tbody>
	</table>
</div>