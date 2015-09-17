<div class="page" id="<?php echo $options['id']?>">
    <div class="header" data-role="header">
        <?php echo $options['header']?>
    </div>
    <?php echo $options['panel']?>
    <div class="content">
        <?php if ( login() ) { ?>
            Welcome, <?php echo login('id')?>
        <?php } ?>
        <?php echo $options['content']?>
    </div>
    <div class="footer" data-role="footer">
        <?php echo $options['footer']?>
    </div>
</div>
