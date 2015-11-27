<!DOCTYPE HTML>
<?php
$phone_number = "062-576-5010";
include "englishworld.functions.php";
$url_ve = "http://englishworld.begin.kr/iframe_login.php?id=".login('id')."&classid=solution&page=solution";
?>
<html>
<head>
<title>명품 화상영어 잉글리쉬월드</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
    <link type='text/css' href='/theme/englishworld/css/base.css' rel='stylesheet' />
    <link type='text/css' href='/theme/englishworld/css/layout.css' rel='stylesheet' />
    <link type='text/css' href='/theme/englishworld/css/component.css' rel='stylesheet' />
    <link type='text/css' href='/theme/englishworld/css/component.grid.css' rel='stylesheet' />
    <link type='text/css' href='/theme/englishworld/css/wooree-grid3.css' rel='stylesheet' />
    <link rel="icon" type="image/ico" href="/theme/englishworld/favicon.ico?v=3"/>
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
<script> var url_server_app = "http://<?php echo $_SERVER['HTTP_HOST']; ?>/app/"; </script>
<?php add_javascript('englishworld.js'); ?>
<?php widget('timezone'); ?>
</body>
</html>
