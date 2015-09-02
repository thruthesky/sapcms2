<?php
add_css();
?>
<ul id="main-menu">
    <?php if ( admin() ) { ?>
        <li><a href="<?php echo url_admin_page(); ?>" class="ui-btn ui-btn-icon-left ui-icon-user">Admin Page</a></li>
    <?php } ?>
    <li><a href="<?php echo url_site(); ?>"><img src="/theme/default/tmp/s.png"></a></li>
    <li><a href="<?php echo url_site(); ?>"><img src="/theme/default/tmp/question.png"></a></li>
    <li><a href="<?php echo url_site(); ?>"><img src="/theme/default/tmp/comment.png"></a></li>
    <li><a href="<?php echo url_site(); ?>"><img src="/theme/default/tmp/anchor.png"></a></li>
    <li><a href="<?php echo url_site(); ?>"><img src="/theme/default/tmp/news.png"></a></li>
    <li><a href="<?php echo url_site(); ?>"><img src="/theme/default/tmp/jobs.png"></a></li>
    <li><a href="<?php echo url_site(); ?>"><img src="/theme/default/tmp/greetings.png"></a></li>
    <li><a href="<?php echo url_site(); ?>"><img src="/theme/default/tmp/menu.png"></a></li>
</ul>


<?php include template('panel'); ?>