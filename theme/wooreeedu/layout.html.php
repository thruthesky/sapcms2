<!DOCTYPE HTML>
<?php
include "wooreeedu.functions.php";
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
    <link type='text/css' href='/theme/wooreeedu/css/base.css' rel='stylesheet' />
    <link type='text/css' href='/theme/wooreeedu/css/layout.css' rel='stylesheet' />
    <link type='text/css' href='/theme/wooreeedu/css/component.css' rel='stylesheet' />
    <link type='text/css' href='/theme/wooreeedu/css/component.grid.css' rel='stylesheet' />
    <link type='text/css' href='/theme/wooreeedu/css/wooree-grid3.css' rel='stylesheet' />
    <link rel="icon" type="image/ico" href="/theme/wooreeedu/favicon.ico?v=2"/>
</head>
<body>
<div id="layout">
    <div id="layout-header"><?php include template('header'); ?></div>
    <div id="layout-content">
		<?php widget('error') ?>
		<?php
			$url_site = 'http://'.domain();//temp?
			include template(); 
		?>
    </div>
    <div id="layout-footer"><?php include template('footer'); ?></div>
</div>
<!--[if lt IE 9]>
<script type='text/javascript' src='/core/etc/js/jquery-1.11.3/jquery-1.11.3.min.js'></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type='text/javascript' src='/core/etc/js/jquery-2.1.4/jquery-2.1.4.min.js'></script>
<!--<![endif]-->
<?php add_javascript('wooreeedu.js'); ?>
<?php widget('timezone'); ?>
</body>
</html>