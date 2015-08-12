<?php if( !empty( $variables['notice'] ) ){?>
<div class='notice'>
	<?php echo $variables['notice']['type'] ?> : <?php echo $variables['notice']['message'] ?>
</div>
<?php }?>
<?php
	$path = __DIR__;
	include $path."/smsgate.queue.html.php"
?>