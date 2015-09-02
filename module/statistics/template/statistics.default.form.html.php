<?php
	extract( $variables );	

	//all fields that will be queried
	$list =	[
			'created'=>'User Registers',
			//'changed'=>'User Updates',
			'last_login'=>'User Logins',
			'block'=>'Blocked Users',
			'resign'=>'Resigned Users',
			];
	//just text
	$text =	[
			'day'=>'Daily',
			'week'=>'Weekly',
			'month'=>'Monthly',
			];					
	
	$date_by = $data['date_by'];
?>

<form>
	<input type='hidden' name='list_type' value='<?php echo $data['list_type'] ?>'>
	From
	<input type='date' name='date_from' value='<?php echo $data['date_from']?>'>
	To
	<input type='date' name='date_to' value='<?php echo $data['date_to']?>'>
	
	Show by:
	<select name='show_by'>
		<option value="">ALL</option>
		<?php foreach( $text as $key => $value ){ ?>
			<option value='<?php echo $key?>' <?php if( $key == $data['show_by'] ) echo " selected" ?>><?php echo $value?></option>
		<?php } ?>
	</select>
	<input type='submit' value='submit'>
</form>