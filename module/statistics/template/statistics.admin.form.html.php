<?			
	//just text for date_by
	$text =	[
			'day'=>'daily',	
			//'week'=>'Weekly',	
			'month'=>'Monthly',			
			];	
	if( $data['show_by'] == 'month' ) $input_date_type = 'month';
	else $input_date_type = 'date';
?>
<form>
	<input type='hidden' name='list_type' value='<?php echo $data['list_type'] ?>'>
	<?php if( !empty( $data['group_by'] ) ) {?>
		<input type='hidden' name='group_by' value='<?php echo $data['group_by'] ?>'>
	<?php } ?>
	From
	<input type='<?php echo $input_date_type; ?>' name='date_from' value='<?php echo $data['date_from']?>'>
	To
	<input type='<?php echo $input_date_type; ?>' name='date_to' value='<?php echo $data['date_to']?>'>
	
	Show by:
	<select name='show_by'>
		<!--<option value="">ALL</option>-->
		<?php foreach( $text as $key => $value ){ ?>
			<option value='<?php echo $key?>' <?php if( $key == $data['show_by'] ) echo " selected" ?>><?php echo $value?></option>
		<?php } ?>
	</select>
	
	<input type='submit' value='submit'>
</form>