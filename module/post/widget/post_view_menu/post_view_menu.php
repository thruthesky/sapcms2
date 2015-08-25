<?php
add_css();
$url_list = post()->getListUrl();
$url_edit = post()->getEditUrl();
?>

<a href="<?php echo $url_list?>">LIST</a>
<a href="<?php echo $url_edit?>">EDIT</a>

