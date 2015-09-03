<!doctype html>
<?php
?>
<html>
<head>
    <meta charset="utf-8">
    <link type='text/css' href='/theme/default/css/base.css' rel='stylesheet' />
    <link type='text/css' href='/theme/default/css/layout.css' rel='stylesheet' />
    <link type='text/css' href='/theme/default/css/component.css' rel='stylesheet' />
</head>
<body>
<div id="layout">
    <div id="header"><?php include template('header'); ?></div>
    <div id="content">
        <table cellpadding="0" cellspacing="0">
            <tr valign="top">
                <td id="content-left"><?php include template('left'); ?></td>
                <td>
                    <?php widget('error') ?>
                    <?php include template(); ?>
                </td>
            </tr>
        </table>
    </div>
    <div id="footer"><?php include template('footer'); ?></div>
</div>
<!--[if lt IE 9]>
<script type='text/javascript' src='/core/etc/js/jquery-1.11.3/jquery-1.11.3.min.js'></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type='text/javascript' src='/core/etc/js/jquery-2.1.4/jquery-2.1.4.min.js'></script>
<!--<![endif]-->
<?php add_javascript('default.js'); ?>
<?php widget('timezone'); ?>
</body>
</html>