<?php
add_css();
$posts = post()->postListData();
?>
<div class="list">
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <th class="no">NO</th>
            <th class="title">TITLE</th>
            <th class="name">Name</th>
            <th class="view">View</th>
            <th class="date">Date</th>
        </tr>
        <?php foreach( $posts as $post ) { ?>
            <tr class="row">
                <td class="no"><a href="<?php echo url_post_view($post)?>"><span><?php echo $post['idx']?></span></a></td>
                <td class="title"><a href="<?php echo url_post_view($post)?>"><span><?php widget('post_list_title', ['post'=>$post]); ?></span></a></td>
                <td class="name"><a href="<?php echo url_post_view($post)?>"><span><?php echo $post['user']['id']?></span></a></td>
                <td class="view"><a href="<?php echo url_post_view($post)?>"><span><?php echo $post['no_view'];?></span></a></td>
                <td class="date"><a href="<?php echo url_post_view($post)?>"><span><?php echo date_short($post['created']);?></span></a></td>
            </tr>
        <?php } ?>
    </table>
</div>

