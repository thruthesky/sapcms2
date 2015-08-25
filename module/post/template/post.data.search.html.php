<?php

?>

<?php widget('post_list_search_box'); ?>
Total Record: <?php echo $variables['total_record']?><hr>
<div class="post search">
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

