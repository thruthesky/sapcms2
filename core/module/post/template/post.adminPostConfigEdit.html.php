<?php include template('post.admin.menu'); 
extract( module()->getVariables() );




if( !empty( $post_config ) ){
?>
<form action="/admin/post/config/edit_submit" method="post">
	<input type="hidden" name="id" value="<?php echo $post_config['id']; ?>">

    Post configuration ID : <br>
	<b><?php echo $post_config['id']; ?></b><br>

    Post configuration name :
    <input type="text" name="name" value="<?php echo $post_config['name']; ?>">

    Post configuration Description :
    <input type="text" name="description" value="<?php echo $post_config['description']; ?>">


    Item Per Page
    <input type="text" name="<?php echo NO_ITEM?>" value="<?php echo $post_config[NO_ITEM]; ?>">

    Item Per Nav
    <input type="text" name="<?php echo NO_PAGE?>" value="<?php echo $post_config[NO_PAGE]; ?>">
	
    Widget List
    <?php

    $s = html_select([
        'name' => 'widget_list',
        'default' => $post_config['widget_list'],
        'options' => $variables['widget_list']
    ]);

    echo $s;

    ?>

    Show List Widget Under View
    <input type="radio" id="show_list_under_view_yes" name="show_list_under_view" value="Y" <?php if ( $post_config['show_list_under_view'] == 'Y' ) echo "checked=1"; ?>>
    <label for="show_list_under_view_yes">Yes</label>
    <input type="radio" id="show_list_under_view_no" name="show_list_under_view" value="N" <?php if ( $post_config['show_list_under_view'] != 'Y' ) echo "checked=1"; ?>>
    <label for="show_list_under_view_no">No</label>



    Widget View
    <input type="text" name="widget_view" value="<?php echo $post_config['widget_view']; ?>">
	
    Widget Edit
    <input type="text" name="widget_edit" value="<?php echo $post_config['widget_edit']; ?>">
	
    Widget Comment
    <input type="text" name="widget_comment" value="<?php echo $post_config['widget_comment']; ?>">
	
    Widget Search
    <input type="text" name="widget_search_box" value="<?php echo $post_config['widget_search_box']; ?>">

    <input type="submit" value="UPDATE">
</form>
<?php
}else{
	echo "<h1>Error or Missing Post data</h1>";
}