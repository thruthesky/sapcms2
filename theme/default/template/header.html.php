<?php
add_css();
?>
<div id="header-top">
<ul id="main-menu" class="clearfix">
    <li><a href="<?php echo url_site(); ?>"><span class="logo"><img src="/theme/default/tmp/s.png"></span></a></li>
    <li><a href="<?php echo url_site(); ?>"><span><img src="/theme/default/tmp/question.png"></span></a></li>
    <li><a href="<?php echo url_site(); ?>"><span><img src="/theme/default/tmp/comment.png"></span></a></li>
    <li><a href="<?php echo url_site(); ?>"><span><img src="/theme/default/tmp/anchor.png"></span></a></li>
    <li><a href="<?php echo url_site(); ?>"><span><img src="/theme/default/tmp/news.png"></span></a></li>
    <li><a href="<?php echo url_site(); ?>"><span><img src="/theme/default/tmp/jobs.png"></span></a></li>
    <li><a href="<?php echo url_site(); ?>"><span><img src="/theme/default/tmp/greetings.png"></span></a></li>
    <li><span class="show-panel"><img src="/theme/default/tmp/menu.png"></span></li>
</ul>
</div>
<div id="header-bottom" class="clearfix">
    <div id="header-search">
        <form action="/post/search">
            <table width="100%" cellspacing="0" cellpadding="0">
                <tr valign="top">
                    <td width="1%"><img src="/theme/default/tmp/search.png"></td>
                    <td><input type="text" name='q' placeholder="Search"></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include template('panel'); ?>