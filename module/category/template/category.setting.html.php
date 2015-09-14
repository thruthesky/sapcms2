<script src='/module/appdev/js/jquery/jquery-2.1.4.min.js'></script>
<?
add_javascript("category.js");
use sap\src\HTML;
use sap\category\Category;

extract( $variables );
$name = "";
$idx_parent = "";

?>
<div class='category-setting'>
	<h1>Create Root Category</h1>
	<form action="/admin/category/setting/submit" method="post">

		<?php
			if( !empty( $data['category'] ) ) {
				$category = $data['category']->fields;
				echo html_hidden([ "name" => "idx","value"=>$category['idx'] ]);
				$name = $category['name'];
			}
			
			echo html_row([
					'caption' => 'Name',
					'text' => html_input(["name" => "name", 'value'=>$name]),
				]);		
		?>
		<input type="submit">

	</form>
	
	<?php
		$categories = [];
		
		$root_categories = category()->rows("idx_parent = 0");		
		
		
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
	?>
	<?php include template("category.setting.category.table"); ?>
</div>