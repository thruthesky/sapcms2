<!DOCTYPE HTML>
<?php
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
    <link type='text/css' href='/theme/wooreeedu_clean/css/base.css' rel='stylesheet' />
    <link type='text/css' href='/theme/wooreeedu_clean/css/layout.css' rel='stylesheet' />
    <link type='text/css' href='/theme/wooreeedu_clean/css/component.css' rel='stylesheet' />
    <link rel="icon" type="image/ico" href="/theme/wooreeedu_clean/favicon.ico"/>
</head>
<body>
<div id="layout">
    <div id="layout-header"><?php include template('header'); ?></div>
    <div id="layout-content">
		<?php widget('error') ?>
		<?php include template(); ?>
    </div>
    <div id="layout-footer"><?php include template('footer'); ?></div>
</div>
<!--[if lt IE 9]>
<script type='text/javascript' src='/core/etc/js/jquery-1.11.3/jquery-1.11.3.min.js'></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type='text/javascript' src='/core/etc/js/jquery-2.1.4/jquery-2.1.4.min.js'></script>
<!--<![endif]-->
<?php add_javascript('wooreeedu_clean.js'); ?>
<?php widget('timezone'); ?>
</body>
</html>