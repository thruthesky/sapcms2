<?php

?>

<div>Title: <?php echo $post['title']; ?></div>
<div><?php widget('post_view_content'); ?></div>

<a href="/post/list?id=<?php echo $config['id']; ?>">LIST</a>
