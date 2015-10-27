<?php
$route = segment(1);
$post_id = segment(2);
?>
<div class="page" id="<?php echo $options['id']?>" user_id="<?php echo login('id')?>" route="<?php echo $route?>" post_id="<?php echo $post_id?>">
    <div class="header" data-role="header">
        <?php echo $options['header']?>
    </div>
    <?php echo $options['panel']?>
    <div class="content">		
        <?php echo $options['content']?>
    </div>
	<?php if( !empty( $options['footer'] ) ) {?>
		<div class="footer" data-role="footer">
			 <?php echo $options['footer']; ?>
		</div>
	<?php }?>
<!--file image file-loader-->
	<div class='file-loader'>
		<img src="<?php echo url_site(); ?>/module/app/img/loader8.gif">
	</div>	
</div>
