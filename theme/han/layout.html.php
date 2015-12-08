<!DOCTYPE HTML>
<?php
$phone_number = "010-8215-4050";
include "han.functions.php";
$url_ve = "http://han.begin.kr/iframe_login.php?id=".login('id')."&classid=solution&page=solution";
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
    <link type='text/css' href='/theme/han/css/base.css' rel='stylesheet' />
    <link type='text/css' href='/theme/han/css/layout.css' rel='stylesheet' />
    <link type='text/css' href='/theme/han/css/component.css' rel='stylesheet' />
    <link type='text/css' href='/theme/han/css/component.grid.css' rel='stylesheet' />
    <link type='text/css' href='/theme/han/css/wooree-grid3.css' rel='stylesheet' />
    <link rel="icon" type="image/ico" href="/theme/han/favicon.ico?v=3"/>
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
<?php add_javascript('han.js'); ?>
<?php widget('timezone'); ?>
</body>
</html>


<!--[if lte IE 8]>
<style>
/*layout*/
#layout-content {
    margin: auto;
}
/*eo layout*/

/*header*/
.top-menu > .inner .left{
		float:left;
		margin:0;
		width:50%;
		text-align:left;
	}

	.top-menu > .inner .right{
		float:right;
		width:50%;
		text-align:right;
	}
	
	.header-image .label{
		display:block;
		top:25%;
	}
	.top-menu > .inner{		
		padding:7px 0 0 0;	
	}

	#header-top > .inner{
		padding:15px 0;
	}
	
	#header-top > .inner .logo{
		margin-right:10px;
		float:left;
	}
	
	#header-top > .inner ul#main-menu li{	
		float:left;
	}
	
	#header-top > .inner ul#main-menu li a{
		padding:10px 0;
	}
	
	.header-image .label{		
		top:28%;
	}
	.header-image .label{
		top:35%;
	}
/*eo header*/

/*footer*/
	#layout-footer .grid3 .a,
	#layout-footer .grid3 .b,
	#layout-footer .grid3 .c{
		width:300px;
		padding:55px 10px;
	}
	
	#layout-footer .footer-menu .footer-list.contact form input[type='submit']{
		border:1px solid #fff;
	}
/*eo footer*/

/*component.grid*/
	/*grid*/
	   .grid {
			word-break: normal;
		}
		.grid .a,
		.grid .b
		{
			width:50%;
		}
		.grid .a {
			float:left;
		}
	/*eo grid*/

	/*grid3*/
		.grid3 .b{
			display:block;
		}
		
		.grid3 .a,
		.grid3 .b {
			float:left;
		}

		.grid3 .c{
			display:block;		
		}

		.grid3 .a,
		.grid3 .b,
		.grid3 .c {
			width:33.33%;
		}
	/*eo grid3*/
/*eo omponent.grid*/
</style>
<![endif]-->

<!--[if lte IE 7]>
<style>
	.top-menu > .inner .bullet{
		position:relative;
		top:-6px;
	}
	/*outer grid*/
	.grid > *{
		float:left;
		width:475px!important;		
		overflow:hidden;
	}
	
	.grid.second .front-banner{
		width:155px!important;
		margin-bottom:10px!important;
	}
	
	.grid.second .front-banner.kinder, .grid.second .front-banner.kids{
		margin-right:5px;
	}
	
	.page-content.top .b .floater-bar .text{
		height:38px;
	}
	/**/
	
	/*right inner grid*/
	.grid.second > .a, .grid.second > .b{
		width:232px!important;		
	}
	
	.post-hover-title-image .item .title{
		width:212px!important;
	}
	
	.post-hover-title-image .item .title a{
		text-decoration:none;
	}
	/*eo right inner grid*/
</style>
<![endif]-->