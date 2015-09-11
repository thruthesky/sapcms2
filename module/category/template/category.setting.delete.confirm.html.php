<?php
	extract( $variables );
	$categories = $data['children'];
	$parent = $data['parent'];
	
?>
<h2>Category IDX [ <?php echo $parent['idx']?> ] ID [ <?php echo $parent['code']?> ] DESC [ <?php echo $parent['value']?> ] - has children.<br>Are you sure you want to delete this category.</h2>
<a href='/admin/category/setting/deleteSubmit?idx=<?php echo $parent['idx']?>'>Yes</a> <a href="?" onclick='window.history.back()'>No</a>
<?php include template("category.setting.category.table"); ?>
