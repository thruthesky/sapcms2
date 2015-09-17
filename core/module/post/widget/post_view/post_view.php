<?php widget('post_view_menu', $widget)?>
<?php /*temp*/ ?>
<?php widget('post_view_user_profile', ['post'=>post_data()->getCurrent()->getFields()])?>
<?php widget('post_view_title', $widget)?>
<?php widget('post_view_content', ['post'=>post_data()->getCurrent()->getFields()])?>
<?php widget('post_display_files', ['idx'=>post_data()->getCurrent()->get('idx')])?>
<?php widget('post_view_commands', ['post'=>post_data()->getCurrent()->get()])?>
<?php widget('post_view_comment_form', ['post'=>post_data()->getCurrent()->get()])?>
<?php widget('post_view_comment_list')?>

