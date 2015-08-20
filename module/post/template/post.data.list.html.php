<?php
$total_record = post_data()->count();
$posts = post_data()->rows();
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

        <?php } ?>
    </table>
</div>

