<?php

?>
<?php widget('post_list_menu_default'); ?>
<div class="post list">
    <table>
        <tr>
            <th>NO</th>
            <th>TITLE</th>
            <th>Name</th>
            <th>Date</th>
        </tr>
        <?php foreach( $posts as $post ) { ?>
            <tr>
                <td><?php echo $post['idx']?></td>
                <td><a href="<?php echo $post['url']?>"><?php echo $post['title']?></a></td>
                <td><?php echo $post['user']['name']?></td>
                <td><?php echo date_short($post['created']);?></td>
            </tr>
        <?php } ?>
    </table>
</div>


<?php widget('post_list_navigator', $variables); ?>
<?php widget('post_list_search_box', $variables); ?>
