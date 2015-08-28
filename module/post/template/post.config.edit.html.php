<?php include template('post.admin.menu'); 
extract( module()->getVariables() );

if( !empty( $post_config ) ){
?>
<form action="/admin/post/config/edit_submit">
	<input type="hidden" name="id" value="<?php echo $post_config['id']; ?>">

    Post configuration ID : <br>
	<b><?php echo $post_config['id']; ?></b><br>

    Post configuration name :
    <input type="text" name="name" value="<?php echo $post_config['name']; ?>">

    Post configuration Description :
    <input type="text" name="description" value="<?php echo $post_config['description']; ?>">

    Item Per Page
    <input type="text" name="no_item_per_page" value="<?php echo $post_config['no_item_per_page']; ?>">

    Item Per Nav
    <input type="text" name="no_page_per_nav" value="<?php echo $post_config['no_page_per_nav']; ?>">
	
    Widget List
    <input type="text" name="widget_list" value="<?php echo $post_config['widget_list']; ?>">
	
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