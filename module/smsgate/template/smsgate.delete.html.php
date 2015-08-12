<?php if( !empty( $variables['notice'] ) ){?>
<div class='notice <?php echo $variables['notice']['type'] ?>'>
	<?php echo $variables['notice']['type'] ?> : <?php echo $variables['notice']['message'] ?>
</div>
<?php }?>
<?php
	$path = __DIR__;
	include $path."/smsgate.queue.html.php"
?>

<style>
	.notice{		
		padding: 10px;
		margin: 0 10px 10px 10px;		
		border-radius: 2px;
		background-color: #f2f2f2;
		font-size: 1em;
		text-align: center;
	}
	
	.notice.success{
		border: 1px solid #009900;
		color: #009900;
	}
	
	.notice.error{
		border: 1px solid red;
		color: red;
	}
</style>