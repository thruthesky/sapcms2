<?php
	extract( $variables );
	$categories = $data['children'];
	$parent = $data['parent'];
	
?>
<h1>Category IDX [ <?php echo $parent['idx']?> ] NAME [ <?php echo $parent['name']?> ] - has children.<br>Are you sure you want to delete this category?</h1>
<a href='/admin/category/setting/deleteSubmit?idx=<?php echo $parent['idx']?>'>Yes</a> <a href="?" onclick='window.history.back()'>No</a>
<h2>Children List</h2>
<?php include template("category.setting.category.table"); ?>
