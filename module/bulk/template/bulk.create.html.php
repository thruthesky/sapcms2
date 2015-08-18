<?php if( !empty( $variables['bulk'] ) ){ 
	$name = $variables['bulk']['name'];
	$message = $variables['bulk']['message'];
	$number = $variables['bulk']['number'];
	$submit_value = "Update";
?>
<h2>Editing Bulk [ <?php echo $name ?> ] - IDX [ <?php echo $variables['bulk']['idx'] ?> ]</h2>
<?php }else{ 
	$name = "";
	$message = "";
	$number = "";
	$submit_value = "Create";
?>
<h2>Create Bulk Message</h2>
<?php } ?>

<?php if( !empty( $variables['message'] ) ){ ?>
<h3 class='error'><?php echo $variables['message'] ?></h3>
<?php } ?>

<form method="post" action='/bulk/create'>
	<?php if( !empty( $variables['bulk'] ) ){ ?>
		<input type='hidden' name='idx' value = "<?php echo $variables['bulk']['idx'] ?>">
	<?php } ?>
    Name
    <input type="text" name="name" value="<?php echo $name ?>">
    Message
    <textarea name="message"><?php echo $message?></textarea>
    Notification Number
    <input type="text" name="number" value="<?php echo $number?>">


    <input type="submit" value="<?php echo $submit_value ?>">

</form>
