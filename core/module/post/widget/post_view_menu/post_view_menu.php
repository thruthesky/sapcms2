<?php
add_css();
//$url_list = post()->urlPostList(null, false);
$url_edit = post()->urlPostEdit();
$url_delete = post()->urlPostDelete();
//$post = post_data()->getCurrent();
?>
<nav class="menu">
	<a class='edit' href="<?php echo $url_edit?>"></a>
	<a class='delete' href="<?php echo $url_delete?>" onclick="return confirmDeletePost('<?php echo "Post IDX [ ".$widget['post']['idx']." ]"; ?>')"></a>
</nav>